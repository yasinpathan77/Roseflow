<?php

namespace Modules\Appearance\Services;

use Illuminate\Support\Facades\Validator;
use \Modules\Appearance\Repositories\HeaderRepository;
use Modules\Appearance\Entities\HeaderSliderPanel;

class HeaderService{
    protected $headerRepository;

    public function __construct(HeaderRepository  $headerRepository)
    {
        $this->headerRepository = $headerRepository;
    }

    public function getAllZones(){
        return $this->headerRepository->getAllZones();
    }
    public function getHeaders(){
        return $this->headerRepository->getHeaders();
    }
    public function getById($id){
        return $this->headerRepository->getById($id);
    }
    
    public function getByIn($ids){
        return $this->headerRepository->getByIn($ids);
    }

    public function update($data){
        return $this->headerRepository->update($data);
    }

    public function addElement($data){

        return $this->headerRepository->addElement($data);
    }
    public function addElement_2($data){

        return $this->headerRepository->addElement_2($data);
    }
    public function updateElement($data){

        return $this->headerRepository->updateElement($data);
    }
    public function updateElement_2($data){

        return $this->headerRepository->updateElement_2($data);
    }
    public function deleteElement($data){
        return $this->headerRepository->deleteElement($data);
    }
    public function deleteElement_2($data){
        return $this->headerRepository->deleteElement_2($data);
    }
    public function sortElement($data){
        return $this->headerRepository->sortElement($data);
    }

    public function getSliders(){
        return $this->headerRepository->getSliders();
    }
    public function getSingleSlider($id){
        return $this->headerRepository->getSingleSlider($id);
    }

    public function updateEnableStatus(array $data)
    {
        return $this->headerRepository->updateEnableStatus($data);
    }

}
