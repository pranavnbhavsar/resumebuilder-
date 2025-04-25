<?php
$title = "Create Resume | Resume Builder";
require './assets/includes/header.php';
require './assets/includes/navbar.php';
$fn->authPage();
?>

<div class="container">
    <div class="bg-white rounded shadow p-2 mt-4" style="min-height:80vh">
        <div class="d-flex justify-content-between border-bottom">
            <h5>Create Resume</h5>
            <div>
                <a class="text-decoration-none" onclick='history.back()'><i class="bi bi-arrow-left-circle"></i> Back</a>
            </div>
        </div>

        <div>
            <form action="actions/createresume.action.php" method="post" class="row g-3 p-3" enctype="multipart/form-data" onsubmit="return validateForm()">
                <div class="col-md-6">
                    <label class="form-label">Resume Industry/Field</label>
                    <select class="form-select" name="resume_title" id="resumeTitle" onchange="toggleCustomTitle()" required>
                        <option value="" disabled selected>Select an industry/field</option>
                        <option value="Medical">Medical</option>
                        <option value="Information Technology">Information Technology</option>
                        <option value="Engineering">Engineering</option>
                        <option value="Education">Education</option>
                        <option value="Finance">Finance</option>
                        <option value="Marketing">Marketing</option>
                        <option value="Other">Other (Specify)</option>
                    </select>
                    <input type="text" name="custom_resume_title" id="customTitle" placeholder="Enter custom title (e.g., Web Developer)" class="form-control mt-2" style="display:none;">
                </div>

                <h5 class="mt-3 text-secondary"><i class="bi bi-person-badge"></i> Personal Information</h5>

                <div class="col-md-6">
                    <label class="form-label">Upload Photo</label>
                    <input type="file" name="photo" class="form-control" accept="image/*" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="full_name" placeholder="Enter your name" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" name="email_id" placeholder="Enter your email" class="form-control" required>
                </div>

                <div class="col-12">
                    <label for="inputAddress" class="form-label">Objective</label>
                    <textarea class="form-control" name="objective"></textarea>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Mobile No</label>
                    <input type="text" name="mobile_no" id="mobileNo" placeholder="Enter 10-digit mobile number" class="form-control" pattern="[0-9]{10}" maxlength="10" required>
                    <div id="mobileError" class="text-danger" style="display:none">Mobile number must be exactly 10 digits</div>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Date Of Birth</label>
                    <input type="date" class="form-control" name="dob" id="dob" required>
                    <div id="dobError" class="text-danger" style="display:none">You must be 18 or older to create a resume</div>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Gender</label>
                    <select class="form-select" name="gender">
                        <option>Male</option>
                        <option>Female</option>
                        <option>Transgender</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Religion</label>
                    <select class="form-select" name="religion">
                        <option>Hindu</option>
                        <option>Muslim</option>
                        <option>Sikh</option>
                        <option>Christian</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Nationality</label>
                    <select class="form-select" name="nationality">
                        <option>Indian</option>
                        <option>Non Indian</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Marital Status</label>
                    <select class="form-select" name="marital_status">
                        <option>Married</option>
                        <option>Single</option>
                        <option>Divorced</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Hobbies</label>
                    <input type="text" name="hobbies" placeholder="Reading Books, Watching Movies" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Languages Known</label>
                    <input type="text" placeholder="Hindi,English" name="languages" class="form-control" required>
                </div>

                <div class="col-12">
                    <label for="inputAddress" class="form-label">Address</label>
                    <input type="text" class="form-control" name="address" id="inputAddress" placeholder="Enter your address" required>
                </div>

                <div class="col-12 text-end">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-floppy"></i> Add Resume</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
    crossorigin="anonymous"></script>

<script>
function toggleCustomTitle() {
    const resumeTitle = document.getElementById('resumeTitle').value;
    const customTitle = document.getElementById('customTitle');
    if (resumeTitle === 'Other') {
        customTitle.style.display = 'block';
        customTitle.required = true;
    } else {
        customTitle.style.display = 'none';
        customTitle.required = false;
        customTitle.value = ''; // Clear custom title when not "Other"
    }
}

function validateForm() {
    // Validate Date of Birth (18+ years)
    const dobInput = document.getElementById('dob');
    const dobError = document.getElementById('dobError');
    const dob = new Date(dobInput.value);
    const today = new Date('2025-02-27'); // Current date as per system
    const ageDiff = today.getFullYear() - dob.getFullYear();
    const monthDiff = today.getMonth() - dob.getMonth();
    const dayDiff = today.getDate() - dob.getDate();

    let age = ageDiff;
    if (monthDiff < 0 || (monthDiff === 0 && dayDiff < 0)) {
        age--;
    }

    if (age < 18) {
        dobError.style.display = 'block';
        dobInput.focus();
        return false;
    }
    dobError.style.display = 'none';

    // Validate Mobile Number (exactly 10 digits)
    const mobileInput = document.getElementById('mobileNo');
    const mobileError = document.getElementById('mobileError');
    const mobilePattern = /^[0-9]{10}$/;
    if (!mobilePattern.test(mobileInput.value)) {
        mobileError.style.display = 'block';
        mobileInput.focus();
        return false;
    }
    mobileError.style.display = 'none';

    // Validate Resume Title
    const resumeTitle = document.getElementById('resumeTitle').value;
    const customTitle = document.getElementById('customTitle');
    if (resumeTitle === 'Other' && customTitle.value.trim() === '') {
        customTitle.focus();
        return false; // Prevent submission if "Other" is selected but no custom title is provided
    }

    return true;
}

// Real-time validation
document.getElementById('dob').addEventListener('change', validateForm);
document.getElementById('mobileNo').addEventListener('input', function(e) {
    this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10); // Allow only numbers, max 10 digits
    validateForm();
});
document.getElementById('resumeTitle').addEventListener('change', toggleCustomTitle);
</script>
</body>
</html>