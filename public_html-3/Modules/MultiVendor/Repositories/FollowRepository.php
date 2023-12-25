<?php
namespace Modules\MultiVendor\Repositories;

use Illuminate\Support\Facades\Auth;
use Modules\MultiVendor\Entities\FollowSeller;

class FollowRepository
{
  
    public function saveFollow($data)
    {
        $follow = FollowSeller::where('seller_id',$data['seller_id'])->where('customer_id',auth()->id())->first();
        if(!$follow){
            FollowSeller::create([
                'seller_id' => $data['seller_id'],
                'customer_id' => auth()->id()
            ]);
            return true;
        }
        return false;
    }

    public function unFollow($data)
    {
        $follow = FollowSeller::where('seller_id',decrypt($data['seller_id']))->where('customer_id',auth()->id())->first();
        if($follow){
            $follow->delete();
            return true;
        }
        return false;
    }

}