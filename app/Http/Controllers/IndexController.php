<?php

namespace App\Http\Controllers;

use App\Http\Services\Response;
use App\Models\Potentials;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Laravel\Lumen\Routing\Controller as BaseController;
use Thunder\SimilarWebApi\ClientFacade as SimilarWebClient;

class IndexController extends BaseController
{
    /**
     * @param \App\Models\Potentials $potentials
     * @return \Illuminate\View\View
     */
    public function index(Potentials $potentials)
    {
        return view('index.twig', ['csrf_token' => csrf_token(), 'potentials' => $potentials->getPotentialsList()]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \Thunder\SimilarWebApi\ClientFacade $similarWebClient
     * @param \App\Models\Potentials $potentials
     * @return \Illuminate\View\View
     */
    public function result(Request $request, SimilarWebClient $similarWebClient, Potentials $potentials)
    {
        $website = $request->get('your_site');
        $website_host = parse_url($website)['host'];
        $full_month = strtotime('now -1 months');
        $start_checking = strtotime('now -6 months');

        $month_end = date('n', $full_month);
        $month_start = date('n', $start_checking);
        $start_site_checking = date('m-Y', $start_checking);
        $end_site_checking = date('m-Y', $full_month);

        $potential = $potentials->getPotential($request->get('country_select'), $month_start, $month_end);

        $potential_calls = round(((end($potential) + prev($potential) + prev($potential)) / 3) * 0.02);

        $resp = $similarWebClient->getTrafficProResponse(
            $website_host,
            'monthly',
            $start_site_checking,
            $end_site_checking,
            false
        )->getValues();
        $website_traffic = array_values($resp);

        $channel_efficiency = round(((end($website_traffic) + prev($website_traffic) + prev($website_traffic)) / 3) * 0.02);
        $website_traffic_sum = array_sum($website_traffic);

        $competitors_traffic_data = [];
        $competitor_site_1 = $request->get('competitor_site_1', null);
        $competitor_site_2 = $request->get('competitor_site_2', null);

        if (!empty($competitor_site_1)) {
            $competitors_traffic_data[] = $this->getCompetitorsData($similarWebClient, $start_site_checking,
                $end_site_checking, $website_traffic_sum, $competitor_site_1);
        }
        if (!empty($competitor_site_2)) {
            $competitors_traffic_data[] = $this->getCompetitorsData($similarWebClient, $start_site_checking,
                $end_site_checking, $website_traffic_sum, $competitor_site_2);
        }

        session([
            'start' => $start_checking,
            'end' => $full_month,
            'website_traffic' => $website_traffic,
            'website' => $website_host,
            'competitors' => $competitors_traffic_data,
            'potential' => $potential,
        ]);

        return view('result.twig',
            [
                'potential_calls' => $potential_calls,
                'channel_efficiency' => $channel_efficiency,
                'website' => $website,
                'competitors_traffic_data' => $competitors_traffic_data,
                'csrf_token' => csrf_token(),
            ]
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Http\Services\Response $response
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function jsonResult(Request $request, Response $response)
    {
        $start = new \DateTime(date('Y-m-d H:i:s', $request->session()->get('start')));
        $end = new \DateTime(date('Y-m-d H:i:s', $request->session()->get('end')));
        $interval = date_interval_create_from_date_string('1 month');
        $name = 'Visits from ' . $start->format('M, Y') . ' to ' . $end->format('M, Y');
        $dates = [];
        while ($start <= $end) {
            $dates[] = $start->format('M, Y');
            $start->add($interval);
        }
        $series = [];

        $potential = $request->session()->get('potential');
        $website_traffic = $request->session()->get('website_traffic');
        $potential = $this->managePotential($potential, $website_traffic);
        $series[] = [
            'name' => $request->session()->get('website'),
            'data' => $website_traffic,
            'color' => 'blue',
            'marker' => ['symbol' => 'circle'],
        ];
        $competitors = $request->session()->get('competitors', []);
        foreach ($competitors as $competitor) {
            $series[] = [
                'name' => $competitor['site'],
                'data' => $competitor['traffic'],
                'color' => 'green',
                'marker' => ['symbol' => 'circle'],
            ];
            $potential = $this->managePotential($potential, $competitor['traffic']);
        }

        $series[] = [
            'name' => 'Potential',
            'data' => $potential,
            'color' => 'red',
            'marker' => ['symbol' => 'circle'],
        ];

        return $response->json(['name' => $name, 'dates' => $dates, 'series' => $series]);
    }

    public function order(Request $request)
    {
        $body = sprintf("Website: %s \nContact name: %s\nContact: %s\n", $request->get('website_name'),
            $request->get('user_name'), $request->get('contact_info'));

        mail('oleg.samorai@gmail.com, arismiatov@prof.estate', 'Order: Express Analysis', $body);
    }

    private function managePotential($potential, $traffic)
    {
        foreach ($traffic as $key => $value) {
            if ($potential[$key] <= $value) {
                $potential[$key] = $value + $value * (rand(1, 2) / 10);
            }
        }

        return $potential;
    }

    private function getCompetitorsData($similarWebClient, $start, $end, $website_traffic, $competitor_site)
    {
        $competitor_site_host = parse_url($competitor_site)['host'];
        $resp = $similarWebClient->getTrafficProResponse(
            $competitor_site_host,
            'monthly',
            $start,
            $end,
            false
        )->getValues();

        $competitor_traffic = array_values($resp);
        $competitor_traffic_sum = array_sum($competitor_traffic);

        return [
            'site' => $competitor_site_host,
            'traffic_diff' => $this->getPercent($website_traffic, $competitor_traffic_sum),
            'class' => $website_traffic > $competitor_traffic_sum ? 'red' : 'green',
            'word' => $website_traffic > $competitor_traffic_sum ? 'less' : 'more',
            'traffic' => $competitor_traffic,
        ];
    }

    private function getPercent($first, $second)
    {
        $greater = ($first > $second) ? $first : $second;
        $smaller = ($first < $second) ? $first : $second;

        return round(($greater - $smaller) / $smaller * 100);
    }
}
