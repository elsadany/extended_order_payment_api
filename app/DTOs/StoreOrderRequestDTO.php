<?php

namespace App\DTOs;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

class StoreOrderRequestDTO extends Data
{
 public string $user_name;
 public string $user_email;
 #[MapInputName('tag_items'), DataCollectionOf(OrderItemsRequestDTO::class)]
 public ?DataCollection $items = null;
//  #[MapInputName('items')]
//     public ?OrderItemsRequestDTO $items = null;
}
