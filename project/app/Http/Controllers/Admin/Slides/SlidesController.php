<?php

namespace App\Http\Controllers\Admin\Slides;


use App\Http\Controllers\Controller;
use App\Shop\Slides\Slide;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;


class SlidesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    // index function
    public function index()
    {
        $slides = Slide::orderby('id', 'desc')->paginate(10);
        return view('admin.slides.index', compact('slides'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.slides.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:225',
            'photo' => 'required|image',
        ]);
        $slide = new Slide;
        $slide->title = $request->title;


        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $filename = 'slide' . '-' . time() . '.' . $photo->getClientOriginalExtension();
            $location = public_path('images/');
            $request->file('photo')->move($location, $filename);

            $slide->photo = $filename;
        }
        $slide->status = $request->status;
        $slide->save();

        return redirect()->route('admin.slides.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Slide $slide
     * @return Response
     */
    public function edit(Slide $slide)
    {
        return view('admin.slides.edit', compact('slide'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Slide $slide
     * @return Response
     * @throws ValidationException
     */
    public function update(Request $request, Slide $slide)
    {
        $this->validate($request, [
            'title' => 'required|max:225',
            'photo' => 'required_without:existing-photo|image'
        ]);

        $slide->title = $request->title;
        $slide->status = $request->status;

        if ($request->hasfile('photo')) {
            $photo = $request->file('photo');
            $filename = 'slide' . '-' . time() . '.' . $photo->getclientoriginalextension();
            $location = public_path('images/');
            $request->file('photo')->move($location, $filename);

            $oldFilename = $slide->photo;

            $slide->photo = $filename;
            if (!empty($slide->photo) && isset($oldFilename)) {
                $this->deletePhoto($oldFilename);
            }
        }

        $slide->save();

        return redirect()->route('admin.slides.index',
            $slide->id)->with('success', 'slide, ' . $slide->title . ' updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $slide = Slide::findOrFail($id);
        $this->deletePhoto($slide->photo);
        $slide->delete();

        return redirect()->route('admin.slides.index')
            ->with('success',
                'Slide has been successfully deleted');
    }

    /**
     * @param Slide $slide
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeImage(Slide $slide)
    {
        $this->deletePhoto($slide->photo);

        $slide->update(['photo' => null]);

        return redirect()->route('admin.slides.edit',
            $slide)->with('success', 'slide photo deleted');
    }

    /**
     * @param string $image
     */
    private function deletePhoto(string $image): void
    {
        unlink(public_path('images/') . $image);
    }
}