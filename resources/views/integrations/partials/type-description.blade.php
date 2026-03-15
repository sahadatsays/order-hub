@switch($type)
    @case('facebook') Import orders from Facebook page and messenger. @break
    @case('woocommerce') Sync orders from your WooCommerce store. @break
    @case('shopify') Pull orders from Shopify automatically. @break
    @case('whatsapp') Capture manual WhatsApp orders. @break
    @case('website') Receive orders from your website via API. @break
    @case('pos') Sync walk-in POS orders. @break
    @case('pathao') Ship orders with Pathao courier service. @break
    @default {{ ucfirst($type) }} integration. @break
@endswitch
