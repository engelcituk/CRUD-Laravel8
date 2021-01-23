<?php

namespace App\Http\Controllers;

use App\Repositories\RepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

abstract class CrudController extends Controller
{
    protected RepositoryInterface $repository;

    protected string $resource;

    /**
     * p. ej.: ProjectRequest::class
     * @var string 
     */
    protected string $formRequest;


    /**
     * p. ej.: Proyecto creado
     * @var string 
     */
    protected string $messageStore;


    /**
     * p. ej.: Proyecto actuaizado
     * @var string 
     */
    protected string $messageUpdate;


    /**
     * p. ej.: Proyecto eliminado
     * @var string 
     */
    protected string $messageDetroy;


    abstract protected function formCreateMetaData(): array;
    abstract protected function formUpdateMetaData(): array;

    public function index(): View
    {
        return view( $this->resource . ".index")->with([
            $this->resource => $this->repository->paginated()
        ]);
    }

    public function create(): View
    {
        $metaData = $this->formCreateMetaData();

        return view( $this->resource . ".create", $metaData);
    }

    public function store(): RedirectResponse
    {
        app($this->formRequest);
        $this->repository->create();

        return redirect()->route( $this->resource. ".index")->with("success", __($this->messageStore) );
    }

    public function edit(): View
    {
        $metaData = $this->formUpdateMetaData();

        return view( $this->resource . ".edit", $metaData);
    }

    public function update(int $id): RedirectResponse
    {
        app( $this->formRequest );
        $this->repository->update($id);

        return redirect()->route( $this->resource. ".index")->with("success", __($this->messageUpdate) );
    }

    public function delete(int $id): RedirectResponse
    {
        app( $this->formRequest );
        $this->repository->delete($id);

        return redirect()->route( $this->resource. ".index")->with("success", __($this->messageDetroy) );
    }
}
