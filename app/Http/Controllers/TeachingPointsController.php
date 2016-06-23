<?php

namespace App\Http\Controllers;

use App\DataTables\TeachingPointsDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateTeachingPointsRequest;
use App\Http\Requests\UpdateTeachingPointsRequest;
use App\Repositories\TeachingPointsRepository;
use Flash;
use InfyOm\Generator\Controller\AppBaseController;
use Response;

class TeachingPointsController extends AppBaseController
{
    /** @var  TeachingPointsRepository */
    private $teachingPointsRepository;

    public function __construct(TeachingPointsRepository $teachingPointsRepo)
    {
        $this->teachingPointsRepository = $teachingPointsRepo;
    }

    /**
     * Display a listing of the TeachingPoints.
     *
     * @param TeachingPointsDataTable $teachingPointsDataTable
     * @return Response
     */
    public function index(TeachingPointsDataTable $teachingPointsDataTable)
    {
        return $teachingPointsDataTable->render('teachingPoints.index');
    }

    /**
     * Show the form for creating a new TeachingPoints.
     *
     * @return Response
     */
    public function create()
    {
        return view('teachingPoints.create');
    }

    /**
     * Store a newly created TeachingPoints in storage.
     *
     * @param CreateTeachingPointsRequest $request
     *
     * @return Response
     */
    public function store(CreateTeachingPointsRequest $request)
    {
        $input = $request->all();

        $teachingPoints = $this->teachingPointsRepository->create($input);

        Flash::success('TeachingPoints saved successfully.');

        return redirect(route('teachingPoints.index'));
    }

    /**
     * Display the specified TeachingPoints.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $teachingPoints = $this->teachingPointsRepository->findWithoutFail($id);

        if (empty($teachingPoints)) {
            Flash::error('TeachingPoints not found');

            return redirect(route('teachingPoints.index'));
        }

        return view('teachingPoints.show')->with('teachingPoints', $teachingPoints);
    }

    /**
     * Show the form for editing the specified TeachingPoints.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $teachingPoints = $this->teachingPointsRepository->findWithoutFail($id);

        if (empty($teachingPoints)) {
            Flash::error('TeachingPoints not found');

            return redirect(route('teachingPoints.index'));
        }

        return view('teachingPoints.edit')->with('teachingPoints', $teachingPoints);
    }

    /**
     * Update the specified TeachingPoints in storage.
     *
     * @param  int              $id
     * @param UpdateTeachingPointsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTeachingPointsRequest $request)
    {
        $teachingPoints = $this->teachingPointsRepository->findWithoutFail($id);

        if (empty($teachingPoints)) {
            Flash::error('TeachingPoints not found');

            return redirect(route('teachingPoints.index'));
        }

        $teachingPoints = $this->teachingPointsRepository->update($request->all(), $id);

        Flash::success('TeachingPoints updated successfully.');

        return redirect(route('teachingPoints.index'));
    }

    /**
     * Remove the specified TeachingPoints from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $teachingPoints = $this->teachingPointsRepository->findWithoutFail($id);

        if (empty($teachingPoints)) {
            Flash::error('TeachingPoints not found');

            return redirect(route('teachingPoints.index'));
        }

        $this->teachingPointsRepository->delete($id);

        Flash::success('TeachingPoints deleted successfully.');

        return redirect(route('teachingPoints.index'));
    }
}
