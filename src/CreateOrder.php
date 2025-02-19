<?php

namespace Anik\Paperfly;

use Anik\Paperfly\Contracts\Transferable;

class CreateOrder implements Transferable
{
    private ?string $orderId = null;
    private string $pickupMerchantName = "";
    private string $pickupMerchantAddress = "";
    private string $pickupMerchantThana = "";
    private string $pickupMerchantDistrict = "";
    private string $pickupMerchantPhone = "";
    private string $productSizeWeight = "";
    private string $productBrief = "";
    private float $weight = 0;
    private float $packagePrice = 0;
    private string $deliveryOption = "";
    private string $customerName = "";
    private string $customerAddress = "";
    private string $customerThana = "";
    private string $customerDistrict = "";
    private string $customerPhone = "";
    private string $specialInstruction = "";
    private string $orderType = "";

    public static function buildFrom(array $values)
    {
        $order = static::build();

        $mapper = [
            'order_id' => 'orderId',
            'reference_id' => 'referenceId',
            'merchant_name' => 'pickupMerchantName',
            'merchant_address' => 'pickupMerchantAddress',
            'merchant_thana' => 'pickupMerchantThana',
            'merchant_district' => 'pickupMerchantDistrict',
            'merchant_phone' => 'pickupMerchantPhone',
            'product_size_weight' => 'productSizeWeight',
            'product_brief' => 'productBrief',
            'weight_in_kilo' => 'maxWeightInKilo',
            'weight_in_gram' => 'maxWeightInGram',
            'package_price' => 'packagePrice',
            'delivery_option' => 'deliveryOption',
            'customer_name' => 'customerName',
            'customer_address' => 'customerAddress',
            'customer_thana' => 'customerThana',
            'customer_district' => 'customerDistrict',
            'customer_phone' => 'customerPhone',
            'special_instruction' => 'specialInstruction',
            'order_type' => 'orderType',
        ];

        foreach ($values as $field => $value) {
            if (isset($mapper[$field])) {
                $order = call_user_func_array([$order, $mapper[$field]], [$value]);
            }
        }

        return $order;
    }

    public static function build(): CreateOrder
    {
        return new self();
    }

    public function orderId(string $orderId): self
    {
        $this->orderId = $orderId;

        return $this;
    }

    public function referenceId(string $orderId)
    {
        return $this->orderId($orderId);
    }

    public function pickupMerchantName(string $name): self
    {
        $this->pickupMerchantName = $name;

        return $this;
    }

    public function pickupMerchantAddress(string $address): self
    {
        $this->pickupMerchantAddress = $address;

        return $this;
    }

    public function pickupMerchantThana(string $thana): self
    {
        $this->pickupMerchantThana = $thana;

        return $this;
    }

    public function pickupMerchantDistrict(string $district): self
    {
        $this->pickupMerchantDistrict = $district;

        return $this;
    }

    public function pickupMerchantPhone(string $phone): self
    {
        $this->pickupMerchantPhone = $phone;

        return $this;
    }

    public function productSizeWeight(string $sizeWeight): self
    {
        $this->productSizeWeight = $sizeWeight;

        return $this;
    }

    public function productBrief(string $productBrief): self
    {
        $this->productBrief = $productBrief;

        return $this;
    }

    public function maxWeightInKilo(float $weightInKilo): self
    {
        $this->weight = $weightInKilo;

        return $this;
    }

    public function maxWeightInGram(float $weightInGram): self
    {
        return $this->maxWeightInKilo($weightInGram / 1000);
    }

    public function packagePrice(float $packagePrice): self
    {
        $this->packagePrice = $packagePrice;

        return $this;
    }

    public function deliveryOption(string $deliverOption): self
    {
        $this->deliveryOption = $deliverOption;

        return $this;
    }

    public function customerName(string $name): self
    {
        $this->customerName = $name;

        return $this;
    }

    public function customerAddress(string $address): self
    {
        $this->customerAddress = $address;

        return $this;
    }

    public function customerThana(string $thana): self
    {
        $this->customerThana = $thana;

        return $this;
    }

    public function customerDistrict(string $district): self
    {
        $this->customerDistrict = $district;

        return $this;
    }

    public function customerPhone(string $phone): self
    {
        $this->customerPhone = $phone;

        return $this;
    }

    public function specialInstruction(string $instruction): self
    {
        $this->specialInstruction = $instruction;

        return $this;
    }

    public function orderType(string $orderType): self
    {
        $this->orderType = $orderType;

        return $this;
    }

    public function method(): string
    {
        return 'POST';
    }

    public function endpoint(): string
    {
        return '/merchant/api/service/new_order.php';
    }

    public function requestBody(): array
    {
        return [
            'merOrderRef' => $this->orderId,
            'pickMerchantName' => $this->pickupMerchantName,
            'pickMerchantAddress' => $this->pickupMerchantAddress,
            'pickMerchantThana' => $this->pickupMerchantThana,
            'pickMerchantDistrict' => $this->pickupMerchantDistrict,
            'pickupMerchantPhone' => $this->pickupMerchantPhone,
            'productSizeWeight' => $this->productSizeWeight,
            'productBrief' => $this->productBrief,
            'max_weight' => $this->weight,
            'packagePrice' => $this->packagePrice,
            'deliveryOption' => $this->deliveryOption,
            'custname' => $this->customerName,
            'custaddress' => $this->customerAddress,
            'customerThana' => $this->customerThana,
            'customerDistrict' => $this->customerDistrict,
            'custPhone' => $this->customerPhone,
            'special_instruction' => $this->specialInstruction,
            'order_type' => $this->orderType,
        ];
    }
}
