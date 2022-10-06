<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductLabel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ProductLabelController extends Controller
{
    public function showLabels($id)
    {
        try {
            $labels = ProductLabel::select('id','title', 'file_name')->where('product_id', $id)->orderBy('id', 'desc')->get();
            return view('admin.product.labels', compact('labels'));
        } catch (\Exception $e) {
            return redirect()->route('dashboard')->with('error', $e->getMessage());
        }
    }

    public function store(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), array(
                'ed_image_data' => 'required',
                'ed_image_json' => 'required',
                'ed_label' => 'required'
            ));
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $product = Product::findOrFail($id);

            $saved_img = $this->saveLabel($request->ed_image_data);

            $product->labels()->create([
                'title' => $request->ed_label,
                'file_name' => $saved_img,
                'content' => $request->ed_image_json,
            ]);

            return redirect()->back()->with('success', "Label created successfully!");
        } catch (\Exception $e) {
            return redirect()->route('dashboard')->with('error', $e->getMessage());
        }
    }

    public function edit(Request $request, $id, $label_id)
    {
        try {
            $label = ProductLabel::findOrFail($label_id);
            return view('admin.product.edit-label', compact('label'));
        } catch (\Exception $e) {
            return redirect()->route('dashboard')->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, $id, $label_id)
    {
        try {
            $validator = Validator::make($request->all(), array(
                'ed_image_data' => 'required',
                'ed_image_json' => 'required',
                'ed_label' => 'required'
            ));
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $label = ProductLabel::findOrFail($label_id);

            $this->removeLabelFile($label->file_name);

            $saved_img = $this->saveLabel($request->ed_image_data);

            $label->update([
                'title' => $request->ed_label,
                'file_name' => $saved_img,
                'content' => $request->ed_image_json,
            ]);

            return redirect()->route('show_labels', $id)->with('success', "Label updated successfully!");
        } catch (\Exception $e) {
            return redirect()->route('dashboard')->with('error', $e->getMessage());
        }
    }

    public function destroy($id, $label_id)
    {
        try {
            $label = ProductLabel::findOrFail($label_id);

            $this->removeLabelFile($label->file_name);

            $label->delete();

            return redirect()->route('show_labels', $id)->with('success', "Label deleted successfully!");
        } catch (\Exception $e) {
            return redirect()->route('dashboard')->with('error', $e->getMessage());
        }
    }


    private function saveLabel($content)
    {
        $image = str_replace('data:image/png;base64,', '', $content);
        $image = str_replace(' ', '+', $image);
        $imageName = time() . '.' . 'png';
        File::put(public_path() . '/uploads/labels/' . $imageName, base64_decode($image));
        return $imageName;
    }


    private function removeLabelFile($name)
    {
        try {
            File::delete(public_path() . '/uploads/labels/' . $name);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
