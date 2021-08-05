<?php

namespace App\Services;

use App\Models\MShopBasket;
use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class ClientTicketService
{

    /**
     * @var Request
     */
    protected $requestData;

    public $clientTicket;
    public $userId;


    public function __construct(Request $requestData){

        $this->requestData = $requestData;

    }


    public function checkClient()
    {

        $this->clientTicket = $this->checkClientTicket();
        $this->userId = null;

        $this->checkAuthToken();

        if ($this->userId)
            $this->updateBasketAfterAuth();

    }


    public function checkClientTicket()
    {

        if ($clientTicket = $this->requestData->header('client_ticket'))
            return $clientTicket;

        return $this->createNewClientTicket();

    }


    public function checkAuthToken()
    {
        if (auth('api')->check())
            $this->userId = auth('api')->id();
    }


    public function createNewClientTicket()
    {

        return $this->generateCode();

    }


    public function generateCode()
    {

        return time().hash_hmac('sha256', Str::random(20), config('client.ticket'));

    }


    public function setBasket(string $key = null, string $order = null, Array $list = [])
    {

        $this->checkClient();

            $card = new MShopBasket;
            $card->user_id = $this->userId ?? null;
            $card->client_ticket = $this->clientTicket ?? null;
            $card->detail = $order ?? null;
            $card->note = $key.' : '.json_encode($list) ?? null;
            $card->save();

    }


    public function getBasket($key = null)
    {

        $this->checkClient();

        if ($this->userId)
            $card = MShopBasket::where('user_id' ,  $this->userId)->orderby('id', 'desc')->first();
        else
            $card = MShopBasket::where('client_ticket' , $this->clientTicket)->orderby('id', 'desc')->first();

        $cardDetail = $card->detail ?? null;
        return $cardDetail;

    }

    public function updateBasketAfterAuth($key = null)
    {
        if ($this->userId && $this->clientTicket){
            $card = MShopBasket::where('client_ticket' , $this->clientTicket)->orderby('id', 'desc')->first();
            if ($card)
                $card->update([
                        'user_id' => $this->userId,
                    ]
                );
        }

    }



    public function deleteBasket($key = null)
    {
        if ($this->clientTicket){
            $cards = MShopBasket::where('client_ticket' , $this->clientTicket)->all();
            if ($cards)
                foreach ($cards as $cardKey => $card)
                    $card->delete();
        }
        if ($this->userId){
            $cards = MShopBasket::where('user_id' , $this->userId)->all();
            if ($cards)
                foreach ($cards as $cardKey => $card)
                    $card->delete();
        }

    }




}
