<?php

namespace App\Services;

use App\Models\Company;
use App\Http\Resources\CompanyResource;
use App\Traits\BaseResponse;
use Illuminate\Http\Exceptions\HttpResponseException;

class CompanyService
{
    use BaseResponse;

    public function all()
    {
        $companies = Company::orderBy('name', 'ASC')->simplePaginate(10);

        return CompanyResource::collection($companies);
    }

    public function store($data)
    {
        try {
            $companies = Company::where('user_id', Auth()->user()->id)->get();
            if($companies->count() > 2) {
                return 'false';
            }
            $data['user_id'] = Auth()->user()->id;
            $company = Company::create($data);

            return new CompanyResource($company);
        } catch (\Exception $e) {
            throw new HttpResponseException(
                $this->sendError('An Error Occured', ['error' => $e->getMessage()], 500)
            );
        }
    }

    public function update($data, $id)
    {
        try {
            $company = Company::find($id);
            if (is_null($company)) {
                return false;
            }
            $company->update($data);

            return new CompanyResource($company);
        } catch (\Exception $e) {

            throw new HttpResponseException(
                $this->sendError('An Error Occured', ['error' => $e->getMessage()], 500)
            );
        }
    }

    public function find($id)
    {
        $company = Company::find($id);
        if (is_null($company)) {
            return false;
        }

        return new CompanyResource($company);
    }

    public function userCompany()
    {
        $companies = Company::where('user_id', Auth()->user()->id)->get();
        

        return CompanyResource::collection($companies);
    }

    public function destroy($id)
    {
        $company = Company::find($id);
        if (is_null($company)) {
            return false;
        }
        $data = $company->delete();

        return $data;
    }
}
