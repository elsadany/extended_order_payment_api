# **Project Deployment Guide**

## **Installation and Deployment**

Follow these steps to deploy the Laravel project:

### **1. Clone the Project Repository**
```bash
git clone <repository_url>
cd <project_directory>
```

### **2. Install Dependencies**
```bash
composer install
```
Ensure that **Composer** is installed on your system before running the above command.

### **3. Configure Environment Variables**
```bash
cp .env.example .env
```
Then update the `.env` file with your **database credentials**, **mail settings**, and any other required configurations.

### **4. Generate Application Key**
```bash
php artisan key:generate
```
### **5. Put DataBase name**
```
create new DB and put name and user,password in .env
```

### **6. Run Database Migrations**
```bash
php artisan migrate
```



### **7. Set JWT Secret Key** (For Authentication)
```bash
php artisan jwt:secret
```

### **8. Run Automated Tests (Optional)**
```bash
php artisan test
```
Ensure that all tests pass before deployment.

### **9. Serve the Application Locally**
```bash
php artisan serve
```
---

## **API Documentation**

You can find the full API documentation here:
[Postman Collection](https://documenter.getpostman.com/view/31707821/2sAYX3q3Ut)

---

## **Adding a New Payment Gateway**

You can add a new **payment gateway** by following these steps:

### **1. Create a Payment Gateway Class**
Create a new class for the payment gateway inside:
```
app/Services/Payments/Gateways/
```
Example (`StripeGateway.php`):
```php
namespace App\Services\Payments\Gateways;

use App\Models\Payment;
use App\Services\Payments\PaymentGatewayInterface;

class StripeGateway implements PaymentGatewayInterface
{
    protected $api_key;
    protected $secret_key;

    function __construct()
    {
        $this->api_key = env('STIPE_API_KEY');
        $this->secret_key = env('STRIPE_SECRET_KEY');
    }

    public function processPayment(Payment $payment)
    {
        // Implement Stripe API logic here
        $payment->status = 'successful';
        $payment->payment_id = 'ST' . uniqid();
        $payment->save();

        return $payment;
    }
}
```
### **2. ADD the Keys to .env**
```
STIPE_API_KEY=
STRIPE_SECRET_KEY=
```
### **3. Register the New Gateway in Factory**
Edit the file:
```
app/Services/Payments/PaymentGatewayFactory.php
```
Add the new gateway inside the `create` method:
```php
public static function create(string $gateway): PaymentGatewayInterface
{
    return match ($gateway) {
        'credit_card' => new CreditCardGateway(),
        'paypal' => new PayPalGateway(),
        'stripe' => new StripeGateway(), // Add new gateway here
        default => throw new \Exception('Unsupported Payment Gateway'),
    };
}
```

### **3. Add to Enum File**
Edit:
```
app/Enums/PaymentGatewaysEnum.php
```
Add the new payment gateway option:
```php
namespace App\Enums;

enum PaymentGatewaysEnum: string
{
    case CREDIT_CARD = 'credit_card';
    case PAYPAL = 'paypal';
    case STRIPE = 'stripe'; // Add new gateway here
}
```

Now, the new payment gateway is available for use!

---

