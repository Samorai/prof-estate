<?php
namespace App\Http\Controllers;

use App\Http\Services\Response;
use App\Models\CheckedSites;
use App\Models\Potentials;
use App\Models\Settings;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class AdminController extends BaseController
{
    public function index()
    {
        return view('admin/index.twig',
            [
                'checkedSites' => CheckedSites::all()
            ]
        );
    }

    public function viewChecked($id)
    {
        return view('admin/checked.twig',
            [
                'checkedSite' => CheckedSites::findById($id)
            ]
        );
    }

    public function deleteChecked($id)
    {
        CheckedSites::findById($id)->delete();

        return redirect('/admin');
    }

    public function deleteSetting($id)
    {
        Settings::findById($id)->delete();

        return redirect('/admin/settings');
    }

    public function dataChecked($id, Response $response)
    {
        $checked = CheckedSites::findById($id);
        return $response->json(['name' => 'Checked ' . $checked->website, 'dates' => $checked->dates, 'series' => $checked->series]);
    }

    public function potentials()
    {
        return view('admin/potentials.twig', ['potentials' => Potentials::all(),]);
    }

    public function addPotential()
    {
        return view('admin/potentials_form.twig', ['csrf_token' => csrf_token(),]);
    }

    public function editPotential($id)
    {
        return view('admin/potentials_form.twig',
            ['csrf_token' => csrf_token(), 'potential' => Potentials::findById($id)]);
    }

    public function deletePotential($id)
    {
        Potentials::findById($id)->delete();

        return redirect('/admin/potentials');
    }

    public function updatePotential(Request $request, Potentials $potentials)
    {
        $id = $request->get('id');

        if (empty($id)) {
            $potentials->setAttributes($request->all())->save();
        } else {
            $potentials->findById($id)->setAttributes($request->all())->save();
        }

        return redirect('/admin/potentials');
    }

    public function getSettings()
    {
        return view('admin/settings.twig',
            ['csrf_token' => csrf_token(), 'settings' => Settings::all()]);
    }

    public function editSettings(Request $request, Settings $settings)
    {
        if ($new = $request->get('new')) {
            $settings->setAttributes($new)->save();
        }

        if ($updated = $request->get('updated'))
        {
            foreach ($updated as $key=>$value) {
                $setting = Settings::where(['key' => $key])->first();
                $setting->value = $value;
                $setting->save();
            }
        }

        return redirect('/admin/settings');
    }
}