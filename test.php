<?php
// config.php
// =============================================
// تنظیمات اتصال به دیتابیس
// =============================================

// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "abtin";

$servername = "89.42.211.171";
$username = "jhtvfzjq_admin";
$password = "GAGea#_&%sS?#(7&";
$dbname = "jhtvfzjq_abtin";

// ایجاد اتصال با MySQLi
$conn = new mysqli($servername, $username, $password, $dbname);

// بررسی اتصال
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// تنظیم کاراکترست برای پشتیبانی از فارسی
$conn->set_charset("utf8mb4");

// =============================================
// توابع کمکی دیتابیس
// =============================================

/**
 * دریافت تمام رکوردها از یک جدول
 */
function getAll($table, $order = "id DESC") {
    global $conn;
    $sql = "SELECT * FROM $table ORDER BY $order";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

/**
 * دریافت یک رکورد با شناسه
 */
function getById($table, $id) {
    global $conn;
    $sql = "SELECT * FROM $table WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

/**
 * دریافت اطلاعات یک سفارش با شناسه
 */
function getOrderById($order_id) {
    global $conn;
    $sql = "SELECT o.*, c.name as customer_name, c.phone as customer_phone 
            FROM orders o 
            LEFT JOIN customers c ON o.customer_id = c.id 
            WHERE o.id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

/**
 * دریافت اطلاعات یک مشتری با شناسه
 */
function getCustomerById($customer_id) {
    global $conn;
    if (!$customer_id) {
        return ['id' => '', 'name' => '-', 'phone' => '-', 'address' => '-', 'initial_debt' => 0];
    }
    $sql = "SELECT * FROM customers WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $customer_id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    if (!$result) {
        return ['id' => $customer_id, 'name' => '-', 'phone' => '-', 'address' => '-', 'initial_debt' => 0];
    }
    return $result;
}

/**
 * دریافت آخرین شماره سفارش (سریال)
 */
function getNextOrderSerial() {
    global $conn;
    $sql = "SELECT MAX(CAST(serial AS UNSIGNED)) as max_serial FROM orders";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $next = ($row['max_serial'] ?? 0) + 1;
    return str_pad($next, 7, '0', STR_PAD_LEFT);
}

/**
 * دریافت لیست سفارشات با فیلتر - اصلاح شده با hardship
 */
function getOrdersList($filters = []) {
    global $conn;
    $sql = "SELECT o.*, c.name as customer_name,
            COALESCE(SUM(oi.qty), 0) as total_qty,
            COALESCE(SUM(oi.hardship), 0) as total_hardship,
            COALESCE(SUM(oi.length_meter), 0) as total_length_meter,
            COALESCE(SUM(oi.area_meter), 0) as total_area_meter,
            COALESCE(SUM(oi.row_price), 0) as total_price
            FROM orders o 
            LEFT JOIN customers c ON o.customer_id = c.id 
            LEFT JOIN order_items oi ON o.id = oi.order_id
            WHERE 1=1";
    $params = [];
    $types = "";
    
    if (!empty($filters['customer_id'])) {
        $sql .= " AND o.customer_id = ?";
        $params[] = $filters['customer_id'];
        $types .= "i";
    }
    if (!empty($filters['from_date'])) {
        $sql .= " AND o.order_date >= ?";
        $params[] = $filters['from_date'];
        $types .= "s";
    }
    if (!empty($filters['to_date'])) {
        $sql .= " AND o.order_date <= ?";
        $params[] = $filters['to_date'];
        $types .= "s";
    }
    if (!empty($filters['search'])) {
        $sql .= " AND (o.serial LIKE ? OR c.name LIKE ? OR o.project LIKE ?)";
        $search = '%' . $filters['search'] . '%';
        $params[] = $search;
        $params[] = $search;
        $params[] = $search;
        $types .= "sss";
    }
    
    $sql .= " GROUP BY o.id ORDER BY o.id DESC";
    
    $stmt = $conn->prepare($sql);
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

/**
 * دریافت اقلام یک سفارش - اصلاح شده با hardship و description
 */
function getOrderItems($order_id) {
    global $conn;
    $sql = "SELECT id, order_id, product_code, product_desc, length, width, qty, asimesir, price, hardship, description, length_meter, area_meter, row_price, sort_order FROM order_items WHERE order_id = ? ORDER BY sort_order ASC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $items = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    
    foreach ($items as &$item) {
        $item['product_desc_extra'] = $item['description'] ?? '';
    }
    
    return $items;
}

/**
 * دریافت مشتریان برای نمایش در لیست با قابلیت جستجو
 */
function getCustomersList($search = '') {
    global $conn;
    $sql = "SELECT id, name, phone, address, initial_debt, is_active FROM customers WHERE 1=1";
    $params = [];
    $types = "";
    
    if (!empty($search)) {
        $sql .= " AND (name LIKE ? OR phone LIKE ? OR id LIKE ?)";
        $searchTerm = '%' . $search . '%';
        $params[] = $searchTerm;
        $params[] = $searchTerm;
        $params[] = $searchTerm;
        $types .= "sss";
    }
    
    $sql .= " ORDER BY name";
    
    $stmt = $conn->prepare($sql);
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

/**
 * دریافت لیست کالاها با جستجو و فیلتر گروه (نسخه کامل - برای استفاده در جاهای دیگر)
 */
function getProductsList($search = '', $group = '') {
    global $conn;
    $sql = "SELECT * FROM products WHERE 1=1";
    
    if (!empty($search)) {
        $search = $conn->real_escape_string($search);
        $sql .= " AND (name LIKE '%$search%' OR code LIKE '%$search%')";
    }
    
    if (!empty($group)) {
        $group = $conn->real_escape_string($group);
        $sql .= " AND group_name = '$group'";
    }
    
    $sql .= " ORDER BY group_name, name";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

/**
 * دریافت لیست ساده کالاها (فقط کد و نام - برای products.php جدید)
 */
function getSimpleProductsList($search = '') {
    global $conn;
    $sql = "SELECT id, code, name, is_active FROM products WHERE 1=1";
    
    if (!empty($search)) {
        $search = $conn->real_escape_string($search);
        $sql .= " AND (name LIKE '%$search%' OR code LIKE '%$search%')";
    }
    
    $sql .= " ORDER BY name";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

/**
 * دریافت گروه‌های کالا
 */
function getProductGroups() {
    global $conn;
    $sql = "SELECT * FROM product_groups ORDER BY name";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

/**
 * دریافت کالا بر اساس کد
 */
function getProductByCode($code) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM products WHERE code = ? AND is_active = 1");
    $stmt->bind_param("s", $code);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

/**
 * دریافت یک کالا با شناسه (برای ویرایش)
 */
function getProductById($id) {
    global $conn;
    $stmt = $conn->prepare("SELECT id, code, name, is_active FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

/**
 * ذخیره سفارش جدید - اصلاح شده با hardship و description
 */
function saveOrder($data, $items, $total_length_meter, $total_area_meter, $total_area_with_waste, $total_price) {
    global $conn;
    
    try {
        $conn->begin_transaction();
        
        $sql = "INSERT INTO orders (
            serial, order_date, delivery_date, customer_id, order_type, 
            project, product_group, document_book, payment_type, waste_percent,
            total_length_meter, total_area_meter, total_area_with_waste, total_price,
            status, created_by, created_at, updated_at
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param(
            "sssisssssddddssi",
            $data['serial'],
            $data['order_date'],
            $data['delivery_date'],
            $data['customer_id'],
            $data['order_type'],
            $data['project'],
            $data['product_group'],
            $data['document_book'],
            $data['payment_type'],
            $data['waste_percent'],
            $total_length_meter,
            $total_area_meter,
            $total_area_with_waste,
            $total_price,
            $data['status'],
            $data['created_by']
        );
        $stmt->execute();
        
        $order_id = $conn->insert_id;
        
        $sql = "INSERT INTO order_items (
            order_id, product_code, product_desc, length, width, 
            qty, asimesir, price, hardship, description, length_meter, area_meter, row_price, sort_order, created_at
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
        
        $stmt = $conn->prepare($sql);
        
        foreach ($items as $item) {
            $stmt->bind_param(
                "issddddddssddi",
                $order_id,
                $item['product_code'],
                $item['product_desc'],
                $item['length'],
                $item['width'],
                $item['qty'],
                $item['asimesir'],
                $item['price'],
                $item['hardship'],
                $item['description'],
                $item['length_meter'],
                $item['area_meter'],
                $item['row_price'],
                $item['sort_order']
            );
            $stmt->execute();
        }
        
        $conn->commit();
        return $order_id;
        
    } catch (Exception $e) {
        $conn->rollback();
        throw $e;
    }
}

/**
 * دریافت تنظیمات سیستم
 */
function getSetting($key) {
    global $conn;
    $sql = "SELECT setting_value FROM settings WHERE setting_key = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $key);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    return $result['setting_value'] ?? null;
}

/**
 * دریافت آمار سفارشات با فیلتر
 */
function getOrderStats($filters = []) {
    global $conn;
    
    $sql = "SELECT 
                COUNT(*) as total_orders,
                COALESCE(SUM(total_price), 0) as total_amount,
                COALESCE(SUM(total_area_meter), 0) as total_area,
                COALESCE(SUM(total_length_meter), 0) as total_length
            FROM orders o
            LEFT JOIN customers c ON o.customer_id = c.id
            WHERE (o.status != 'لغو' OR o.status IS NULL)";
    
    $params = [];
    $types = "";
    
    if (!empty($filters['customer_id'])) {
        $sql .= " AND o.customer_id = ?";
        $params[] = $filters['customer_id'];
        $types .= "i";
    }
    
    if (!empty($filters['from_date'])) {
        $sql .= " AND o.order_date >= ?";
        $params[] = $filters['from_date'];
        $types .= "s";
    }
    
    if (!empty($filters['to_date'])) {
        $sql .= " AND o.order_date <= ?";
        $params[] = $filters['to_date'];
        $types .= "s";
    }
    
    if (!empty($filters['search'])) {
        $search = '%' . $filters['search'] . '%';
        $sql .= " AND (o.serial LIKE ? OR c.name LIKE ? OR o.project LIKE ?)";
        $params[] = $search;
        $params[] = $search;
        $params[] = $search;
        $types .= "sss";
    }
    
    $stmt = $conn->prepare($sql);
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    $stats = $result->fetch_assoc();
    
    if (!$stats) {
        return [
            'total_orders' => 0,
            'total_amount' => 0,
            'total_area' => 0,
            'total_length' => 0
        ];
    }
    
    return $stats;
}

/**
 * دریافت اطلاعات کامل یک سفارش برای چاپ
 */
function getOrderFullInfo($order_id) {
    global $conn;
    $order = getOrderById($order_id);
    if (!$order) {
        return null;
    }
    $order['items'] = getOrderItems($order_id);
    $order['customer'] = getCustomerById($order['customer_id']);
    return $order;
}

// =============================================
// ===== توابع مربوط به صندوق (Cashier) =====
// =============================================

/**
 * دریافت لیست مشتریان برای صندوق
 */
function getCustomersForCashier($search = '') {
    global $conn;
    $sql = "SELECT id, name, phone, address, initial_debt FROM customers WHERE 1=1";
    if (!empty($search)) {
        $search = $conn->real_escape_string($search);
        $sql .= " AND (name LIKE '%$search%' OR phone LIKE '%$search%')";
    }
    $sql .= " ORDER BY name";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

/**
 * دریافت شماره سند بعدی (برای صندوق)
 * فرمت: SN-0001
 */
function getNextReceiptNumber() {
    global $conn;
    
    $check = $conn->query("SHOW TABLES LIKE 'cash_transactions'");
    if ($check->num_rows == 0) {
        return 'SN-0001';
    }
    
    $sql = "SELECT MAX(CAST(SUBSTRING(receipt_number, 4) AS UNSIGNED)) as max FROM cash_transactions";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $num = ($row['max']) ? $row['max'] + 1 : 1;
    } else {
        $num = 1;
    }
    return 'SN-' . str_pad($num, 4, '0', STR_PAD_LEFT);
}

/**
 * دریافت تراکنش‌های امروز (صندوق)
 * مرتب‌سازی بر اساس receipt_date (تاریخ شمسی) به صورت صعودی (قدیمی به جدید)
 */
function getTodayTransactions() {
    global $conn;
    
    $check = $conn->query("SHOW TABLES LIKE 'cash_transactions'");
    if ($check->num_rows == 0) {
        return [];
    }
    
    $today = date('Y-m-d');
    $sql = "
        SELECT ct.*, c.name as customer_name 
        FROM cash_transactions ct
        LEFT JOIN customers c ON ct.customer_id = c.id
        WHERE DATE(ct.created_at) = '$today' AND ct.transaction_type = 'payment'
        ORDER BY ct.receipt_date ASC, ct.created_at ASC
    ";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    return [];
}

/**
 * دریافت تراکنش‌های یک مشتری خاص
 * مرتب‌سازی بر اساس receipt_date (تاریخ شمسی) به صورت صعودی (قدیمی به جدید)
 */
function getCustomerTransactions($customer_id) {
    global $conn;
    $sql = "
        SELECT ct.*, c.name as customer_name 
        FROM cash_transactions ct
        LEFT JOIN customers c ON ct.customer_id = c.id
        WHERE ct.customer_id = ? AND ct.transaction_type = 'payment'
        ORDER BY ct.receipt_date ASC, ct.created_at ASC
    ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $customer_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

/**
 * دریافت جمع کل دریافتی امروز (صندوق)
 */
function getTodayTotal() {
    global $conn;
    
    $check = $conn->query("SHOW TABLES LIKE 'cash_transactions'");
    if ($check->num_rows == 0) {
        return 0;
    }
    
    $today = date('Y-m-d');
    $sql = "SELECT COALESCE(SUM(amount), 0) as total FROM cash_transactions 
            WHERE DATE(created_at) = '$today' AND status = 'active' AND transaction_type = 'payment'";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['total'] ?? 0;
    }
    return 0;
}

/**
 * ثبت تراکنش جدید در صندوق
 */
function saveCashTransaction($data) {
    global $conn;
    
    $sql = "INSERT INTO cash_transactions (
        receipt_number, customer_id, amount, payment_type, 
        description, check_number, receipt_date, transaction_type, created_at, status
    ) VALUES (?, ?, ?, ?, ?, ?, ?, 'payment', NOW(), 'active')";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "sidssss",
        $data['receipt_number'],
        $data['customer_id'],
        $data['amount'],
        $data['payment_type'],
        $data['description'],
        $data['check_number'],
        $data['receipt_date']
    );
    
    return $stmt->execute();
}

/**
 * ابطال یک تراکنش (تغییر وضعیت به voided)
 */
function voidTransaction($transaction_id) {
    global $conn;
    $sql = "UPDATE cash_transactions SET status = 'voided', voided_at = NOW() WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $transaction_id);
    return $stmt->execute();
}

/**
 * دریافت یک تراکنش با شناسه
 */
function getTransactionById($id) {
    global $conn;
    $sql = "SELECT ct.*, c.name as customer_name 
            FROM cash_transactions ct
            LEFT JOIN customers c ON ct.customer_id = c.id 
            WHERE ct.id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

/**
 * دریافت مجموع بدهی یک مشتری
 * (مبلغ کل سفارشات - مبلغ کل پرداختی + بدهی اولیه)
 */
function getCustomerDebt($customer_id) {
    global $conn;
    
    // کل مبلغ سفارشات دوجداره
    $sql1 = "SELECT COALESCE(SUM(total_price), 0) as total_orders FROM orders WHERE customer_id = ? AND status != 'لغو'";
    $stmt1 = $conn->prepare($sql1);
    $stmt1->bind_param("i", $customer_id);
    $stmt1->execute();
    $orders_total = $stmt1->get_result()->fetch_assoc()['total_orders'];
    
    // کل مبلغ سفارشات تک جداره
    $sql1b = "SELECT COALESCE(SUM(total_price), 0) as total_orders FROM order_single WHERE customer_id = ? AND status != 0";
    $stmt1b = $conn->prepare($sql1b);
    $stmt1b->bind_param("i", $customer_id);
    $stmt1b->execute();
    $orders_total += $stmt1b->get_result()->fetch_assoc()['total_orders'];
    
    // کل مبلغ پرداختی (فقط تراکنش‌های عادی)
    $sql2 = "SELECT COALESCE(SUM(amount), 0) as total_paid FROM cash_transactions 
             WHERE customer_id = ? AND status = 'active' AND transaction_type = 'payment'";
    $stmt2 = $conn->prepare($sql2);
    $stmt2->bind_param("i", $customer_id);
    $stmt2->execute();
    $paid_total = $stmt2->get_result()->fetch_assoc()['total_paid'];
    
    // بدهی اولیه مشتری از جدول customers
    $sql3 = "SELECT COALESCE(initial_debt, 0) as initial_debt FROM customers WHERE id = ?";
    $stmt3 = $conn->prepare($sql3);
    $stmt3->bind_param("i", $customer_id);
    $stmt3->execute();
    $initial_debt = $stmt3->get_result()->fetch_assoc()['initial_debt'] ?? 0;
    
    // بدهی = (کل سفارشات - کل پرداختی) + بدهی اولیه
    return ($orders_total - $paid_total) + $initial_debt;
}

/**
 * دریافت آمار کامل صندوق برای یک بازه زمانی
 */
function getCashierStats($from_date = null, $to_date = null) {
    global $conn;
    
    if (!$from_date) $from_date = date('Y-m-d');
    if (!$to_date) $to_date = date('Y-m-d');
    
    $check = $conn->query("SHOW TABLES LIKE 'cash_transactions'");
    if ($check->num_rows == 0) {
        return [
            'total_transactions' => 0,
            'total_amount' => 0,
            'unique_customers' => 0,
            'cash_count' => 0,
            'check_count' => 0,
            'card_count' => 0,
            'transfer_count' => 0,
            'online_count' => 0
        ];
    }
    
    $sql = "
        SELECT 
            COUNT(*) as total_transactions,
            COALESCE(SUM(amount), 0) as total_amount,
            COUNT(DISTINCT customer_id) as unique_customers,
            COUNT(CASE WHEN payment_type = 'نقدی' THEN 1 END) as cash_count,
            COUNT(CASE WHEN payment_type = 'چک' THEN 1 END) as check_count,
            COUNT(CASE WHEN payment_type = 'کارت به کارت' THEN 1 END) as card_count,
            COUNT(CASE WHEN payment_type = 'حواله' THEN 1 END) as transfer_count,
            COUNT(CASE WHEN payment_type = 'پرداخت الکترونیک' THEN 1 END) as online_count
        FROM cash_transactions 
        WHERE DATE(created_at) BETWEEN ? AND ?
        AND status = 'active' AND transaction_type = 'payment'
    ";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $from_date, $to_date);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    
    if (!$result) {
        return [
            'total_transactions' => 0,
            'total_amount' => 0,
            'unique_customers' => 0,
            'cash_count' => 0,
            'check_count' => 0,
            'card_count' => 0,
            'transfer_count' => 0,
            'online_count' => 0
        ];
    }
    
    return $result;
}

/**
 * دریافت لیست تراکنش‌ها با فیلترهای مختلف
 * مرتب‌سازی بر اساس receipt_date (تاریخ شمسی) به صورت صعودی (قدیمی به جدید)
 */
function getTransactionsList($filters = []) {
    global $conn;
    
    $sql = "
        SELECT ct.*, c.name as customer_name 
        FROM cash_transactions ct
        LEFT JOIN customers c ON ct.customer_id = c.id 
        WHERE ct.transaction_type = 'payment'
    ";
    $params = [];
    $types = "";
    
    if (!empty($filters['customer_id'])) {
        $sql .= " AND ct.customer_id = ?";
        $params[] = $filters['customer_id'];
        $types .= "i";
    }
    
    if (!empty($filters['from_date'])) {
        $sql .= " AND ct.receipt_date >= ?";
        $params[] = $filters['from_date'];
        $types .= "s";
    }
    
    if (!empty($filters['to_date'])) {
        $sql .= " AND ct.receipt_date <= ?";
        $params[] = $filters['to_date'];
        $types .= "s";
    }
    
    if (!empty($filters['payment_type'])) {
        $sql .= " AND ct.payment_type = ?";
        $params[] = $filters['payment_type'];
        $types .= "s";
    }
    
    if (!empty($filters['status'])) {
        $sql .= " AND ct.status = ?";
        $params[] = $filters['status'];
        $types .= "s";
    }
    
    $sql .= " ORDER BY ct.receipt_date ASC, ct.created_at ASC";
    
    $stmt = $conn->prepare($sql);
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

/**
 * دریافت لیست سفارشات یک مشتری (دوجداره)
 */
function getCustomerOrders($customer_id) {
    global $conn;
    $sql = "SELECT * FROM orders WHERE customer_id = ? AND (status != 'لغو' OR status IS NULL) ORDER BY id DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $customer_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

// =============================================
// ===== توابع جدید برای دریافت سفارشات تک جداره و ترکیبی =====
// =============================================

/**
 * دریافت سفارشات تک جداره یک مشتری
 */
function getCustomerOrdersSingle($customer_id) {
    global $conn;
    
    $stmt = $conn->prepare("
        SELECT 
            so.*,
            'تک جداره' as order_type_label,
            so.total_price
        FROM order_single so
        WHERE so.customer_id = ? AND so.status != 0
        ORDER BY so.id DESC
    ");
    $stmt->bind_param("i", $customer_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $orders = [];
    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }
    return $orders;
}

/**
 * دریافت تمام سفارشات مشتری (هر دو نوع دوجداره و تک جداره) به همراه تراکنش‌ها
 * و مرتب‌سازی بر اساس تاریخ (قدیمی به جدید)
 */

/**
 * دریافت تمام سفارشات مشتری (هر دو نوع دوجداره و تک جداره) به همراه تراکنش‌ها
 * و مرتب‌سازی بر اساس تاریخ (قدیمی به جدید)
 */
function getAllCustomerOrders($customer_id) {
    global $conn;
    
    $items = [];
    
    // 1. سفارشات دوجداره
    $stmt = $conn->prepare("
        SELECT 
            o.*,
            'دوجداره' as type_label,
            o.total_price as amount,
            o.order_date as date,
            'order' as item_type,
            o.serial as number,
            o.project as description
        FROM orders o
        WHERE o.customer_id = ? AND (o.status != 'لغو' OR o.status IS NULL)
    ");
    $stmt->bind_param("i", $customer_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        // تبدیل تاریخ به فرمت یکسان (تبدیل - به /)
        $row['date'] = str_replace('-', '/', $row['date']);
        $items[] = $row;
    }
    
    // 2. سفارشات تک جداره
    $stmt2 = $conn->prepare("
        SELECT 
            so.*,
            'تک جداره' as type_label,
            so.total_price as amount,
            so.order_date as date,
            'order' as item_type,
            so.serial as number,
            so.project as description
        FROM order_single so
        WHERE so.customer_id = ? AND so.status != 0
    ");
    $stmt2->bind_param("i", $customer_id);
    $stmt2->execute();
    $result2 = $stmt2->get_result();
    while ($row = $result2->fetch_assoc()) {
        // تبدیل تاریخ به فرمت یکسان (تبدیل - به /)
        $row['date'] = str_replace('-', '/', $row['date']);
        $items[] = $row;
    }
    
    // 3. تراکنش‌های مالی
    $stmt3 = $conn->prepare("
        SELECT 
            ct.*,
            ct.payment_type as type_label,
            ct.amount,
            ct.receipt_date as date,
            'transaction' as item_type,
            ct.receipt_number as number,
            ct.description
        FROM cash_transactions ct
        WHERE ct.customer_id = ? AND ct.transaction_type = 'payment' AND ct.status = 'active'
    ");
    $stmt3->bind_param("i", $customer_id);
    $stmt3->execute();
    $result3 = $stmt3->get_result();
    while ($row = $result3->fetch_assoc()) {
        $items[] = $row;
    }
    
    // ===== اصلاح اصلی: مرتب‌سازی بر اساس تاریخ با تبدیل به عدد =====
    usort($items, function($a, $b) {
        $dateA = $a['date'] ?? '';
        $dateB = $b['date'] ?? '';
        
        // حذف کاراکترهای / و - برای مقایسه عددی
        $cleanA = str_replace(['/', '-'], '', $dateA);
        $cleanB = str_replace(['/', '-'], '', $dateB);
        
        // مقایسه عددی
        return $cleanA <=> $cleanB;
    });
    
    return $items;
}

/**
 * دریافت یک مشتری با شناسه (نسخه کامل برای صندوق)
 */
function getCustomer($customer_id) {
    global $conn;
    $sql = "SELECT * FROM customers WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $customer_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

/**
 * دریافت بدهی اولیه یک مشتری
 */
function getInitialDebt($customer_id) {
    global $conn;
    $sql = "SELECT COALESCE(initial_debt, 0) as initial_debt FROM customers WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $customer_id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    return $result['initial_debt'] ?? 0;
}

// =============================================
// ===== توابع مربوط به سفارش تک جداره =====
// =============================================

/**
 * دریافت آخرین شماره سفارش تک جداره (سریال)
 * فرمت: S-0001
 */
function getNextOrderSerialSingle() {
    global $conn;
    $sql = "SELECT serial FROM order_single ORDER BY id DESC LIMIT 1";
    $result = $conn->query($sql);
    
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $last_serial = $row['serial'];
        $num = (int) substr($last_serial, 2);
        $num++;
        return 'S-' . str_pad($num, 4, '0', STR_PAD_LEFT);
    } else {
        return 'S-0001';
    }
}

/**
 * ذخیره سفارش تک جداره جدید
 */
function saveOrderSingle($data, $items, $total_qty, $total_sqm, $total_price) {
    global $conn;
    
    try {
        $conn->begin_transaction();
        
        $sql = "INSERT INTO order_single (
            serial, order_date, customer_id, phone, order_type, 
            project, product_group, delivery_date, document_book, payment_type,
            total_qty, total_sqm, total_price, status, created_at
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1, NOW())";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param(
            "ssisssssssddi",
            $data['serial'],
            $data['order_date'],
            $data['customer_id'],
            $data['phone'],
            $data['order_type'],
            $data['project'],
            $data['product_group'],
            $data['delivery_date'],
            $data['document_book'],
            $data['payment_type'],
            $total_qty,
            $total_sqm,
            $total_price
        );
        $stmt->execute();
        
        $order_id = $conn->insert_id;
        
        $sql = "INSERT INTO order_single_items (
            order_id, product_code, product_desc, qty, sqm, price, product_desc_extra, row_total
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        
        foreach ($items as $item) {
            $row_total = $item['sqm'] * $item['price'];
            
            $stmt->bind_param(
                "issddssd",
                $order_id,
                $item['product_code'],
                $item['product_desc'],
                $item['qty'],
                $item['sqm'],
                $item['price'],
                $item['product_desc_extra'],
                $row_total
            );
            $stmt->execute();
        }
        
        $conn->commit();
        return $order_id;
        
    } catch (Exception $e) {
        $conn->rollback();
        throw $e;
    }
}

/**
 * دریافت لیست سفارشات تک جداره با فیلتر
 */
function getOrdersListSingle($filters = []) {
    global $conn;
    
    $sql = "SELECT o.*, c.name as customer_name,
            COALESCE(SUM(oi.qty), 0) as total_qty,
            COALESCE(SUM(oi.sqm), 0) as total_sqm,
            COALESCE(SUM(oi.row_total), 0) as total_price
            FROM order_single o 
            LEFT JOIN customers c ON o.customer_id = c.id 
            LEFT JOIN order_single_items oi ON o.id = oi.order_id
            WHERE 1=1";
    
    $params = [];
    $types = "";
    
    if (!empty($filters['customer_id'])) {
        $sql .= " AND o.customer_id = ?";
        $params[] = $filters['customer_id'];
        $types .= "i";
    }
    if (!empty($filters['from_date'])) {
        $sql .= " AND o.order_date >= ?";
        $params[] = $filters['from_date'];
        $types .= "s";
    }
    if (!empty($filters['to_date'])) {
        $sql .= " AND o.order_date <= ?";
        $params[] = $filters['to_date'];
        $types .= "s";
    }
    if (!empty($filters['search'])) {
        $sql .= " AND (o.serial LIKE ? OR c.name LIKE ? OR o.project LIKE ?)";
        $search = '%' . $filters['search'] . '%';
        $params[] = $search;
        $params[] = $search;
        $params[] = $search;
        $types .= "sss";
    }
    
    $sql .= " GROUP BY o.id ORDER BY o.id DESC";
    
    $stmt = $conn->prepare($sql);
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

/**
 * دریافت آمار سفارشات تک جداره با فیلتر
 */
function getOrderStatsSingle($filters = []) {
    global $conn;
    
    $sql = "SELECT 
                COUNT(*) as total_orders,
                COALESCE(SUM(total_price), 0) as total_amount,
                COALESCE(SUM(total_sqm), 0) as total_sqm,
                COALESCE(SUM(total_qty), 0) as total_qty
            FROM order_single
            WHERE 1=1";
    
    $params = [];
    $types = "";
    
    if (!empty($filters['customer_id'])) {
        $sql .= " AND customer_id = ?";
        $params[] = $filters['customer_id'];
        $types .= "i";
    }
    
    if (!empty($filters['from_date'])) {
        $sql .= " AND order_date >= ?";
        $params[] = $filters['from_date'];
        $types .= "s";
    }
    
    if (!empty($filters['to_date'])) {
        $sql .= " AND order_date <= ?";
        $params[] = $filters['to_date'];
        $types .= "s";
    }
    
    $stmt = $conn->prepare($sql);
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    $stats = $result->fetch_assoc();
    $stmt->close();
    
    if (!$stats) {
        return [
            'total_orders' => 0,
            'total_amount' => 0,
            'total_sqm' => 0,
            'total_qty' => 0
        ];
    }
    
    return $stats;
}

/**
 * دریافت اطلاعات کامل یک سفارش تک جداره با شناسه
 */
function getOrderByIdSingle($order_id) {
    global $conn;
    
    $sql = "SELECT o.*, c.name as customer_name, c.phone as customer_phone 
            FROM order_single o
            LEFT JOIN customers c ON o.customer_id = c.id
            WHERE o.id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $order = $result->fetch_assoc();
    $stmt->close();
    
    if ($order) {
        $order['items'] = getOrderItemsSingle($order_id);
    }
    
    return $order;
}

/**
 * دریافت اقلام یک سفارش تک جداره
 */
function getOrderItemsSingle($order_id) {
    global $conn;
    $sql = "SELECT * FROM order_single_items WHERE order_id = ? ORDER BY id ASC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $items = [];
    while ($row = $result->fetch_assoc()) {
        $items[] = $row;
    }
    $stmt->close();
    
    return $items;
}

/**
 * بروزرسانی سفارش تک جداره
 */
function updateOrderSingle($order_id, $data, $items, $total_qty, $total_sqm, $total_price) {
    global $conn;
    
    try {
        $conn->begin_transaction();
        
        // بروزرسانی اطلاعات اصلی
        $sql = "UPDATE order_single SET 
                    customer_id = ?,
                    phone = ?,
                    order_type = ?,
                    project = ?,
                    product_group = ?,
                    delivery_date = ?,
                    document_book = ?,
                    payment_type = ?,
                    total_qty = ?,
                    total_sqm = ?,
                    total_price = ?,
                    status = ?,
                    updated_at = NOW()
                WHERE id = ?";
        
        $stmt = $conn->prepare($sql);
        $status_numeric = match($data['status']) {
            'لغو' => 0,
            'ثبت' => 1,
            'تایید' => 2,
            'تکمیل شده' => 3,
            default => 1
        };
        
        $stmt->bind_param(
            "issssssdddisi",
            $data['customer_id'],
            $data['phone'],
            $data['order_type'],
            $data['project'],
            $data['product_group'],
            $data['delivery_date'],
            $data['document_book'],
            $data['payment_type'],
            $total_qty,
            $total_sqm,
            $total_price,
            $status_numeric,
            $order_id
        );
        $stmt->execute();
        $stmt->close();
        
        // حذف اقلام قبلی
        $stmt = $conn->prepare("DELETE FROM order_single_items WHERE order_id = ?");
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        $stmt->close();
        
        // اضافه کردن اقلام جدید
        $sql = "INSERT INTO order_single_items (
            order_id, product_code, product_desc, qty, sqm, price, product_desc_extra, row_total
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        
        foreach ($items as $item) {
            $row_total = $item['sqm'] * $item['price'];
            
            $stmt->bind_param(
                "issddssd",
                $order_id,
                $item['product_code'],
                $item['product_desc'],
                $item['qty'],
                $item['sqm'],
                $item['price'],
                $item['product_desc_extra'],
                $row_total
            );
            $stmt->execute();
        }
        $stmt->close();
        
        $conn->commit();
        return true;
        
    } catch (Exception $e) {
        $conn->rollback();
        throw $e;
    }
}
?>