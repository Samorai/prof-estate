<?php
namespace App\Http\Controllers;

use App\Models\Potentials;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class AdminController extends BaseController
{
    public function index()
    {
        return view('admin/index.twig',
            [

            ]
        );
    }

    public function potentials()
    {
        return view('admin/potentials.twig',
            [
                'potentials' => Potentials::all(),
            ]
        );
    }

    public function addPotential()
    {
        return view('admin/potentials_form.twig', ['csrf_token' => csrf_token(),]);
    }

    public function updatePotential(Request $request, Potentials $potentials)
    {
        $id = $request->get('id');

        if (empty($id)) {
            $potentials->setAttributes($request->all())->save();
        }
        return redirect('/admin/potentials');
    }
}