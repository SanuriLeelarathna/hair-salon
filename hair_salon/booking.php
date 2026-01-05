<?php
session_start();
include 'db_connect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Hairdressers Service - Glamour Hair Salon</title>
<link rel="stylesheet" href="style.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<style>
* { box-sizing: border-box; font-family: 'Poppins', Arial, sans-serif; }
body { background: #D9D9D9; margin: 0; padding: 0; }

/* Layout Wrapper */
.booking-wrapper {
    display: flex;
    max-width: 1100px;
    margin: 50px auto;
    background: #ffffff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}
.booking-image {
    flex: 1;
    background-image: url('images/ap.jpg');
    background-size: cover;
    background-position: center;
    min-height: 650px;
}
.container { flex: 1; padding: 40px; }

/* Form Styling */
h2 { margin: 0; color: #46315C; }
.subtitle { color: #68507B; font-size: 13px; margin-bottom: 20px; }
label { display: block; margin-top: 15px; font-weight: 600; font-size: 13px; color: #46315C; }
input, select { width: 100%; padding: 10px; border-radius: 6px; border: 1.5px solid #B3A5BA; margin-top: 5px; }

/* Time Slots */
.time-slots { margin-top: 15px; display: grid; grid-template-columns: repeat(3, 1fr); gap: 8px; }
.time-slot { padding: 10px; text-align: center; border: 1.5px solid #8D769A; color: #46315C; border-radius: 6px; cursor: pointer; font-size: 12px; background: #fff; transition: 0.3s; }
.time-slot:hover { background: #B3A5BA; }
.time-slot.active { background: #46315C; color: white; border-color: #46315C; }
.time-slot.full { background: #ccc; color: #666; cursor: not-allowed; border-color: #ccc; }

/* Submit Button */
button.submit-btn {
    background: #20001c; width: 100%; margin-top: 25px; padding: 12px;
    border: none; color: white; font-size: 14px; border-radius: 8px;
    cursor: pointer; font-weight: bold;
}

/* Modal / Pop-up Styling */
.modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.85); display: flex; justify-content: center; align-items: center; z-index: 9999; }
.modal-content { position: relative; width: 90%; max-width: 450px; background: #000000ff; border-radius: 15px; border: 1px solid #D4AF37; animation: popIn 0.3s ease-out; overflow: hidden; }
.close-btn { position: absolute; right: 15px; top: 10px; color: #D4AF37; font-size: 30px; cursor: pointer; z-index: 10; }

/* Confirmation Card UI */
.confirmation-card { 
    background: #000000ff; 
    color: #ffffff; 
    padding: 20px; 
    text-align: center;
     
}
.gold-text { 
    color: #B8860B; 
    font-size: 22px; 
    margin: 15px 0;
    font-family: 'Antic Didone',serif; 
}
.details-box { 
    text-align: left; 
    display: block; 
    padding: 0 20px; 
}
.details-box p { color: #E9E4EC; margin: 8px 0; font-size: 14px; }
.details-box strong { color: #D4AF37; }

.download-btn { background: transparent; border: 2px solid #D4AF37; color: #D4AF37; padding: 10px 30px; font-weight: bold; cursor: pointer; margin-bottom: 20px; }
.download-btn:hover { background: #D4AF37; color: #000000ff; }

@keyframes popIn { from { transform: scale(0.8); opacity: 0; } to { transform: scale(1); opacity: 1; } }
@media (max-width: 768px) { .booking-wrapper { flex-direction: column; margin: 10px; } .booking-image { min-height: 250px; } }
</style>
</head>
<body>

<header>
  <div class="logo">
    <img src="images/glmr.png" alt="Glamour Hair Salon Logo">
  </div>

  <nav>
    <ul>
      <li><a href="home.php#home" class="active">Home</a></li>
      <li><a href="booking.php">Book Now</a></li>
      <li><a href="product.php">Shop</a></li>
      <?php if(isset($_SESSION['user'])): ?>
        <li><a href="profile.php" style="color:#e99fe0;">Hi, <?= $_SESSION['user']; ?></a></li>
        <li><a href="logout.php" class="logout-btn">Logout</a></li>
      <?php else: ?>
        <li><a href="login.php">Login</a></li>
        <li><a href="signup.php">Sign Up</a></li>
      <?php endif; ?>
    </ul>
  </nav>
</header>

<div class="booking-wrapper">
    <div class="booking-image"></div>
    <div class="container">
        <h2>Hairdressers Service</h2>
        <p class="subtitle">Make an Appointment with the Hairdresser</p>

        <form method="POST" id="bookingForm">
            <label>Full Name</label>
            <input type="text" name="name" required>

            <label>Email</label>
            <input type="email" name="email" required>

            <label>Appointment Date</label>
            <input type="date" name="date" required id="datePicker">

            <label>Service Required</label>
            <select name="service" required>
                <option value="">Please Select</option>
                <option>Haircut</option>
                <option>Hair Coloring</option>
                <option>Styling</option>
                <option>Hair Straightening</option>
                <option>Hair Smoothing</option>
            </select>

            <label>Select Time</label>
            <div class="time-slots" id="timeSlotsContainer">
                <div class="time-slot" data-time="09:00">09:00</div>
                <div class="time-slot" data-time="10:00">10:00</div>
                <div class="time-slot" data-time="11:00">11:00</div>
                <div class="time-slot" data-time="14:00">14:00</div>
                <div class="time-slot" data-time="15:00">15:00</div>
                <div class="time-slot" data-time="16:00">16:00</div>
            </div>

            <input type="hidden" name="time" id="time_input" required>
            <button type="submit" name="submit" class="submit-btn">Request an Appointment</button>
        </form>

        <?php
        if(isset($_POST['submit'])){
            $name = $_POST['name'];
            $email = $_POST['email'];
            $date = $_POST['date'];
            $service = $_POST['service'];
            $time = $_POST['time'];

            if(empty($time)){
                echo "<p style='color:red;'>Please select a time!</p>";
            } else {
                // Check if selected time slot already has 5 bookings
                $stmt = $conn->prepare("SELECT COUNT(*) AS cnt FROM bookings WHERE date=? AND time=? AND status='active'");
                $stmt->bind_param("ss", $date, $time);
                $stmt->execute();
                $res = $stmt->get_result()->fetch_assoc();
                if($res['cnt'] >= 5){
                    echo "<p style='color:red;'>Sorry! This time slot is fully booked.</p>";
                } else {
                    $stmt = $conn->prepare("INSERT INTO bookings (name,email,date,time,service,status) VALUES (?,?,?,?,?,'active')");
                    $stmt->bind_param("sssss",$name,$email,$date,$time,$service);
                    if($stmt->execute()){
                        $id = $conn->insert_id;
                        echo "
                        <div id='confirmModal' class='modal-overlay'>
                            <div class='modal-content'>
                                <span class='close-btn' onclick='closeModal()'>&times;</span>
                                <div id='download-area' class='confirmation-card'>
                                    <img src='images/finlog.png' style='width:50%;' alt='Header'>
                                    <h2 class='gold-text'>Appointment Confirmed</h2>
                                    <div class='details-box'>
                                        <p><strong>Full Name:</strong> $name</p>
                                        <p><strong>Email:</strong> $email</p>
                                        <p><strong>Date:</strong> $date</p>
                                        <p><strong>Time:</strong> $time</p>
                                        <p><strong>Service:</strong> $service</p>
                                        <p><strong>Ref No:</strong> #AP$id</p>
                                    </div>
                                </div>
                                <div style='text-align:center;'>
                                    <button class='download-btn' onclick='saveAsPDF()'>DOWNLOAD PDF</button>
                                </div>
                            </div>
                        </div>";
                    }
                }
            }
        }
        ?>
    </div>
</div>

<script>
const slots = document.querySelectorAll('.time-slot');
const timeInput = document.getElementById('time_input');
const datePicker = document.getElementById('datePicker');

function updateSlots(date){
    slots.forEach(s => {
        s.classList.remove('full');
        s.classList.remove('active');
        s.style.pointerEvents = 'auto';
    });

    if(!date) return;

    fetch('check_slots.php?date=' + date)
    .then(res => res.json())
    .then(data => {
        slots.forEach(s => {
            let time = s.dataset.time;
            if(data[time] >= 5){
                s.classList.add('full');
                s.style.pointerEvents = 'none';
            }
        });
    });
}

// Date picker changes
datePicker.addEventListener('change', () => {
    updateSlots(datePicker.value);
    timeInput.value = '';
});

// Slot selection
slots.forEach(slot => {
    slot.addEventListener('click', function(){
        if(this.classList.contains('full')) return;
        slots.forEach(s => s.classList.remove('active'));
        this.classList.add('active');
        timeInput.value = this.dataset.time;
    });
});

function closeModal(){
    document.getElementById('confirmModal').style.display = 'none';
}

// PDF download
function saveAsPDF(){
    const element = document.getElementById('download-area');
    const opt = {
        margin: 0.2,
        filename: 'Glamour_Booking_#AP.pdf',
        image: { type: 'jpeg', quality: 1 },
        html2canvas: { scale: 2, backgroundColor: '#10091D' },
        jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
    };
    html2pdf().set(opt).from(element).save();
}
</script>

</body>
</html>
