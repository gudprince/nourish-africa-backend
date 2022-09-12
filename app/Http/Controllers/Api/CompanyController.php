<?php

namespace App\Http\Controllers\Api;

use App\Traits\BaseResponse;
use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Services\CompanyService;
use App\Http\Controllers\Controller;

class CompanyController extends Controller
{
    use BaseResponse;

    public $companyService;

    public function __construct(CompanyService $companyService)
    {
        $this->companyService = $companyService;
    }

    public function index()
    {
        $companies = $this->companyService->all();
        if (!count($companies) > 0) {
            return $this->sendResponse($companies, 'Record is Empty.');
        }
        return $this->sendResponse($companies, 'Record retrieved successfully.');
    }

    public function save(StoreCompanyRequest $request)
    {
        $company = $this->companyService->store($request->all());

        return $this->sendResponse($company, 'Company Created Successfully.', 201);
    }

    public function find($id)
    {
        $company = $this->companyService->find($id);
        if (!$company) {
            return $this->sendError('Company not Found.', [], 404);
        }
        return $this->sendResponse($company, 'Company Retrieved Successfully.');
    }

    public function update(UpdateCompanyRequest $request, $id)
    {
        $company = $this->companyService->update($request->all(), $id);
        if (!$company) {
            return $this->sendError('Company not Found.', [], 404);
        }
        return $this->sendResponse($company, 'Company Updated Successfully.');
    }

    public function delete($id)
    {
        $company = $this->companyService->destroy($id);
        if (!$company) {
            return $this->sendError('Company not Found.', [], 404);
        }
        return $this->sendResponse($company, 'Company Deleted successfully.');
    }
}
