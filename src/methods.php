<?php

namespace Anik\Paperfly;

const STATUS_UNKNOWN = 'unknown';
const STATUS_PICKED = 'picked';
const STATUS_IN_TRANSIT = 'in_transit';
const STATUS_RECEIVED_AT_LMH = 'received_at_lmh';
const STATUS_ASSIGNED_TO_DELIVERY_AGENT = 'assigned_to_delivery_agent';
const STATUS_ON_HOLD = 'on_hold';
const STATUS_DELIVERED = 'delivered';
const STATUS_RETURNED = 'returned';
const STATUS_PARTIAL = 'partial';
const STATUS_INVOICED = 'invoiced';
const STATUS_CLOSED = 'closed';

function orderStatus(array $info): string
{
    if ($info['STATUS_CLOSED'] ?? null) {
        return STATUS_CLOSED;
    }
    if ($info['invNum'] ?? null) {
        return STATUS_INVOICED;
    }
    if ($info['onHoldSchedule'] ?? null) {
        return STATUS_ON_HOLD;
    }
    if ($info['PartialTime'] ?? null) {
        return STATUS_PARTIAL;
    }
    if ($info['ReturnedTime'] ?? null) {
        return STATUS_RETURNED;
    }
    if ($info['DeliveredTime'] ?? null) {
        return STATUS_DELIVERED;
    }
    if ($info['PickedForDeliveryTime'] ?? null) {
        return STATUS_ASSIGNED_TO_DELIVERY_AGENT;
    }
    if ($info['ReceivedAtPointTime'] ?? null) {
        return STATUS_RECEIVED_AT_LMH;
    }
    if ($info['inTransitTime'] ?? null) {
        return STATUS_IN_TRANSIT;
    }
    if ($info['inTransitTime'] ?? null) {
        return STATUS_PICKED;
    }

    return STATUS_UNKNOWN;
}
