<?php
namespace Born\OrderController\Api;

interface GuestorderInterface
{
    /**
     * Return mixed.
     *
     * @api
     * @param string $param.
     * @return mixed.
     */
    public function getGuestOrderHistory($param);
}