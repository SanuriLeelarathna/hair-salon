<?php
session_start();
include 'db_connect.php';

/* Uncomment to protect admin page
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin.php");
    exit();
}
*/

// =================== HANDLE UPDATE ===================
if (isset($_POST['update'])) {
    $order_id = $_POST['order_id'];
    $status = $_POST['status']; // Pending, Process, Delivered

    // Only update if user hasn't cancelled the order
    $check = $conn->query("SELECT cancelled_by_user FROM p_orders WHERE id=$order_id")->fetch_assoc();
    if (!$check['cancelled_by_user']) {
        $conn->query("UPDATE p_orders SET status='$status' WHERE id=$order_id");
    }

    echo "<script>window.location='manage_product_orders.php';</script>";
}

// =================== HANDLE DELETE ===================
if (isset($_POST['delete'])) {
    $id = $_POST['delete_id'];
    $conn->query("DELETE FROM p_orders WHERE id=$id");
    echo "<script>window.location='manage_product_orders.php';</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Product Orders</title>
    <style>
        

        h2 {
            text-align: left;
            margin-bottom: 30px;
        }
        table{width:100%;border-collapse:collapse}
        th,td{padding:10px;border:1px solid #ccc;text-align:center}
th{background:#3e1940;color:#fff}

/* Action Buttons */
.btn-delete {
    color: #e74c3c;
    background: none;
    border: 1px solid #e74c3c;
    padding: 5px 10px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 12px;
    transition: 0.3s;
}

.btn-delete:hover {
    background: #e74c3c;
    color: #fff;
}

.status-pill {
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: bold;
    background: #e5f9e7;
    color: #27ae60;
}

      
        .delete-btn {
            background: #c0392b;
            color: white;
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .delete-btn:hover {
            background: #e74c3c;
        }

        .update-btn {
            background: #0d711aff;
            color: white;
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .update-btn:hover {
            background: #34db63ff;
        }

        select {
            padding: 4px;
            border-radius: 4px;
            border: none;
        }

        select:disabled {
            background: #555;
            cursor: not-allowed;
        }

        .status {
            font-weight: bold;
            text-transform: capitalize;
        }

        .status.pending { color: orange; }
        .status.process { color: orange; }
        .status.delivered { color: green; }
        .status.cancelled { color: red; }
        .status.user-cancelled { color: red; }

        a.back {
            display: inline-block;
            margin-bottom: 15px;
            color: #e99fe0;
            text-decoration: none;
        }
    </style>
</head>
<body>



<h2>🛒 Manage Product Orders</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Customer</th>
        <th>Product</th>
        <th>Qty</th>
        <th>Address</th>
        <th>Phone</th>
        <th>Order Date</th>
        <th>Status</th>
        <th>Actions</th>
    </tr>

<?php
$sql = "
SELECT 
    p_orders.id,
    p_orders.customer_name,
    p_orders.quantity,
    p_orders.address,
    p_orders.phone,
    p_orders.order_date,
    p_orders.status,
    p_orders.cancelled_by_user,
    products.name AS product_name
FROM p_orders
JOIN products ON p_orders.product_id = products.id
ORDER BY p_orders.id DESC
";

$result = $conn->query($sql);

if ($result->num_rows > 0):
    while ($row = $result->fetch_assoc()):
        // Determine status display
        if ($row['cancelled_by_user']) {
            $status_class = 'user-cancelled';
            $display_status = 'Cancelled by User';
        } else {
            $status_class = strtolower($row['status']);
            $display_status = $row['status'];
        }
?>
<tr>
    <td><?= $row['id']; ?></td>
    <td><?= htmlspecialchars($row['customer_name']); ?></td>
    <td><?= htmlspecialchars($row['product_name']); ?></td>
    <td><?= $row['quantity']; ?></td>
    <td><?= htmlspecialchars($row['address']); ?></td>
    <td><?= htmlspecialchars($row['phone']); ?></td>
    <td><?= date('F j, Y', strtotime($row['order_date'])); ?></td>
    
    <!-- STATUS UPDATE -->
    <td>
        <?php if ($row['cancelled_by_user']): ?>
            <span class="status <?= $status_class ?>"><?= $display_status ?></span>
        <?php else: ?>
            <form method="POST" style="display:flex; gap:5px; justify-content:center;">
                <input type="hidden" name="order_id" value="<?= $row['id']; ?>">
                <select name="status">
                    <option value="Pending" <?= $row['status']=='Pending'?'selected':'' ?>>Pending</option>
                    <option value="Process" <?= $row['status']=='Process'?'selected':'' ?>>Process</option>
                    <option value="Delivered" <?= $row['status']=='Delivered'?'selected':'' ?>>Delivered</option>
                </select>
                <button type="submit" name="update" class="update-btn">Update</button>
            </form>
        <?php endif; ?>
    </td>

    <!-- DELETE ORDER -->
    <td>
        <form method="POST" onsubmit="return confirm('Delete this order?');">
            <input type="hidden" name="delete_id" value="<?= $row['id']; ?>">
            <button class="delete-btn" name="delete">Delete</button>
        </form>
    </td>
</tr>
<?php
    endwhile;
else:
?>
<tr>
    <td colspan="10">No orders found</td>
</tr>
<?php endif; ?>
</table>
<script>
/**
 * Handles both Update and Delete without refreshing the entire page.
 */
function processOrderAction(event, formElement) {
    event.preventDefault(); // Prevents the browser from leaving the page

    const formData = new FormData(formElement);

    fetch('manage_product_orders.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        // Since we are in an AJAX dashboard, we call the main loader 
        // function to refresh the current white space area.
        if (typeof loadContent === "function") {
            loadContent('manage_product_orders.php'); 
        } else {
            // Fallback: If you haven't named your main loader 'loadContent'
            location.reload(); 
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert("Something went wrong. Please try again.");
    });
}
</script>
</body>
</html>
