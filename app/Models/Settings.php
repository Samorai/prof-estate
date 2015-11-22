<?php
namespace App\Models;

class Settings extends Base
{

    protected $attributes = [
        'key' => '',
        'value' => null,
    ];

    protected $default_index_texts = [
        'index_txt_title' => 'Analysis of activity on the internet',
        'index_txt_country' => 'Country',
        'index_txt_your_site' => 'Your site',
        'index_txt_comp_1' => 'Your competitor\'s site 1',
        'index_txt_comp_2' => 'Your competitor\'s site 2',
    ];

    protected $default_result_texts = [
        'res_txt_title' => 'Result of analysis',
        'res_txt_first_group_title' => 'Is your online<br/>channel effective?',
        'res_txt_first_group_txt_1' => 'The number of calls<br/>that you have<br/>to receive each month',
        'res_txt_first_group_txt_2' => 'If you do not get this amount of calls, you should analyze<br/>your advertising activities on the Internet.',
        'res_txt_first_group_txt_3' => 'Do you want to know<br/>how to increase efficacy?',
        'res_txt_second_group_title' => 'Your potential',
        'res_txt_second_group_txt_1' => 'The number of calls<br/>that you can receive<br/> each month',
        'res_txt_second_group_txt_2' => 'Do you want to know<br/>how to get it?',
        'res_txt_third_group_title' => 'How are your<br/>competitors?',
        'res_txt_third_group_txt_1' => 'Do you want to now how<br/>to get ahead of the competition?',
        'res_txt_order' => 'Do you want to lower customer acquisition costs?',
        'res_txt_order_txt_1' => 'Let\'s start with the analysis of your curren online presence and compare it to best practices and your competitors:',
        'res_txt_order_li' => '<li>You vs best industry practices</li><li>You vs your closest competitors</li>',
        'res_txt_order_txt_2' => 'All you need to do is input your website and you will get your free custom made PDF report prepared by our market analysis team.',

    ];


    public function getIndexTexts()
    {
        $index_texts = self::where('key', '$regex', new \MongoRegex("/^index_txt.+/"))->get()->all();
        foreach ($index_texts as $text) {
            $this->default_index_texts[$text->key] = $text->value;
        }

        return $this->default_index_texts;
    }

    public function getResultTexts()
    {
        $index_texts = self::where('key', '$regex', new \MongoRegex("/^res_txt.+/"))->get()->all();
        foreach ($index_texts as $text) {
            $this->default_result_texts[$text->key] = $text->value;
        }

        return $this->default_result_texts;
    }
}