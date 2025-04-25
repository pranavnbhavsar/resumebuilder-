<?php
$title = "Create Resume | Resume Builder";
require './assets/includes/header.php';
require './assets/includes/navbar.php';
$fn->authPage();
$slug = $_GET['resume'] ?? '';
$resumes = $db->query("SELECT * FROM resumes WHERE ( slug='$slug' AND user_id=" . $fn->Auth()['id'] . ") ");
$resume = $resumes->fetch_assoc();
if (!$resume) {
    $fn->redirect('myresumes.php');
}

$exps = $db->query("SELECT * FROM experiences WHERE (resume_id=" . $resume['id'] . " ) ");
$exps = $exps->fetch_all(1);

$edus = $db->query("SELECT * FROM educations WHERE (resume_id=" . $resume['id'] . " ) ");
$edus = $edus->fetch_all(1);

$skills = $db->query("SELECT * FROM skills WHERE (resume_id=" . $resume['id'] . " ) ");
$skills = $skills->fetch_all(1);
?>

<div class="container">
    <div class="bg-white rounded shadow p-2 mt-4" style="min-height:80vh">
        <div class="d-flex justify-content-between border-bottom">
            <h5>Create Resume</h5>
            <div>
                <a href="myresumes.php" class="text-decoration-none"><i class="bi bi-arrow-left-circle"></i> Back</a>
            </div>
        </div>

        <div>
            <form action="actions/updateresume.action.php" method="post" class="row g-3 p-3">
                <input type="hidden" name="id" value="<?=$resume['id']?>">
                <input type="hidden" name="slug" value="<?=$resume['slug']?>">
                <div class="col-md-6">
                    <label class="form-label">Resume Title</label>
                    <input type="text" name="resume_title" placeholder="Web Developer Consultant" value="<?=@$resume['resume_title']?>" class="form-control" required>
                </div>
                
                <h5 class="mt-3 text-secondary"><i class="bi bi-person-badge"></i> Personal Information</h5>
                <div class="col-md-6">
                    <label class="form-label">Full Name</label>
                    <input type="text" value="<?=@$resume['full_name']?>" name="full_name" placeholder="Enter your name" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" value="<?=@$resume['email_id']?>" name="email_id" placeholder="Enter your email" class="form-control" required>
                </div>
                <div class="col-12">
                    <label for="inputAddress" class="form-label">Objective</label>
                    <textarea class="form-control" name="objective"><?=@$resume['objective']?></textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Mobile No</label>
                    <input type="number" min="1111111111" value="<?=@$resume['mobile_no']?>" name="mobile_no" placeholder="Enter your Number" max="9999999999" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Date Of Birth</label>
                    <input type="date" class="form-control" value="<?=$resume['dob']?>" name="dob" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Gender</label>
                    <select class="form-select" name="gender">
                        <option <?=($resume['gender']=='Male')?'selected':''?>>Male</option>
                        <option <?=($resume['gender']=='Female')?'selected':''?>>Female</option>
                        <option <?=($resume['gender']=='Transgender')?'selected':''?>>Transgender</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Religion</label>
                    <select class="form-select" name="religion">
                        <option <?=($resume['religion']=='Hindu')?'selected':''?>>Hindu</option>
                        <option <?=($resume['religion']=='Muslim')?'selected':''?>>Muslim</option>
                        <option <?=($resume['religion']=='Sikh')?'selected':''?>>Sikh</option>
                        <option <?=($resume['religion']=='Christian')?'selected':''?>>Christian</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Nationality</label>
                    <select class="form-select" name="nationality">
                        <option <?=($resume['nationality']=='Indian')?'selected':''?>>Indian</option>
                        <option <?=($resume['nationality']=='Non Indian')?'selected':''?>>Non Indian</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Marital Status</label>
                    <select class="form-select" name="marital_status">
                        <option <?=($resume['marital_status']=='Married')?'selected':''?>>Married</option>
                        <option <?=($resume['marital_status']=='Single')?'selected':''?>>Single</option>
                        <option <?=($resume['marital_status']=='Divorced')?'selected':''?>>Divorced</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Hobbies</label>
                    <input type="text" name="hobbies" value="<?=@$resume['hobbies']?>" placeholder="Reading Books, Watching Movies" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Languages Known</label>
                    <input type="text" placeholder="Hindi,English" value="<?=@$resume['languages']?>" name="languages" class="form-control" required>
                </div>
                <div class="col-12">
                    <label for="inputAddress" class="form-label">Address</label>
                    <input type="text" value="<?=@$resume['address']?>" class="form-control" name="address" id="inputAddress" placeholder="Enter your address" required>
                </div>

                <!-- Experience Section -->
                <hr>
                <div class="d-flex justify-content-between">
                    <h5 class="text-secondary"><i class="bi bi-briefcase"></i> Experience</h5>
                    <div>
                        <a class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#addexp"><i class="bi bi-file-earmark-plus"></i> Add New</a>
                    </div>
                </div>
                <div class="d-flex flex-wrap">
                    <?php
                    if ($exps) {
                        foreach ($exps as $exp) {
                    ?>
                        <div class="col-12 col-md-6 p-2">
                            <div class="p-2 border rounded">
                                <div class="d-flex justify-content-between">
                                    <h6><?=$exp['position']?></h6>
                                    <a href="actions/deleteexp.action.php?id=<?=$exp['id']?>&resume_id=<?=$resume['id']?>&slug=<?=$resume['slug']?>"><i class="bi bi-x-lg"></i></a>
                                </div>
                                <p class="small text-secondary m-0">
                                    <i class="bi bi-buildings"></i> <?=$exp['company']?> (<?=$exp['started'].' - '.$exp['ended']?>)
                                </p>
                                <p class="small text-secondary m-0">
                                    <?=$exp['job_desc']?>
                                </p>
                            </div>
                        </div>
                    <?php
                        }
                    } else {
                    ?>
                        <div class="col-12 col-md-6 p-2">
                            <div class="p-2 border rounded">
                                <div class="d-flex justify-content-between">
                                    <h6>I am Fresher</h6>
                                </div>
                                <p class="small text-secondary m-0">
                                    If you have experience, you can add it
                                </p>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>

                <!-- Education Section -->
                <hr>
                <div class="d-flex justify-content-between">
                    <h5 class="text-secondary"><i class="bi bi-journal-bookmark"></i> Education</h5>
                    <div>
                        <a href="" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#addedu"><i class="bi bi-file-earmark-plus"></i> Add New</a>
                    </div>
                </div>
                <div class="d-flex flex-wrap">
                    <?php
                    if ($edus) {
                        foreach ($edus as $edu) {
                    ?>
                        <div class="col-12 col-md-6 p-2">
                            <div class="p-2 border rounded">
                                <div class="d-flex justify-content-between">
                                    <h6><?=$edu['course']?></h6>
                                    <a href="actions/deleteedu.action.php?id=<?=$edu['id']?>&resume_id=<?=$resume['id']?>&slug=<?=$resume['slug']?>"><i class="bi bi-x-lg"></i></a>
                                </div>
                                <p class="small text-secondary m-0">
                                    <i class="bi bi-book"></i> <?=$edu['institute']?>
                                </p>
                                <p class="small text-secondary m-0">
                                    <?=$edu['started']?> - <?=$edu['ended'] === 'Present' ? 'Pursuing' : $edu['ended']?>
                                </p>
                                <p class="small text-secondary m-0">
                                    <?php
                                    if ($edu['grade_type'] && $edu['grade']) {
                                        if ($edu['grade_type'] == 'grade') echo "Grade: " . $edu['grade'];
                                        elseif ($edu['grade_type'] == 'marks') echo "Marks: " . $edu['grade'] . "%";
                                        elseif ($edu['grade_type'] == 'cgpa') echo "CGPA: " . $edu['grade'];
                                    }
                                    ?>
                                </p>
                            </div>
                        </div>
                    <?php
                        }
                    } else {
                    ?>
                        <div class="col-12 col-md-6 p-2">
                            <div class="p-2 border rounded">
                                <div class="d-flex justify-content-between">
                                    <h6>I have no education</h6>
                                </div>
                                <p class="small text-secondary m-0">
                                    If you have education, you can add it
                                </p>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>

                <!-- Skills Section -->
                <hr>
                <div class="d-flex justify-content-between">
                    <h5 class="text-secondary"><i class="bi bi-boxes"></i> Skills</h5>
                    <div>
                        <a href="" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#addskill"><i class="bi bi-file-earmark-plus"></i> Add New</a>
                    </div>
                </div>
                <div class="d-flex flex-wrap">
                    <?php
                    if ($skills) {
                        foreach ($skills as $skill) {
                    ?>
                        <div class="col-12 p-2">
                            <div class="p-2 border rounded">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6><i class="bi bi-caret-right"></i> <?=$skill['skill']?></h6>
                                    <a href="actions/deleteskill.action.php?id=<?=$skill['id']?>&resume_id=<?=$resume['id']?>&slug=<?=$resume['slug']?>"><i class="bi bi-x-lg"></i></a>
                                </div>
                            </div>
                        </div>
                    <?php
                        }
                    } else {
                    ?>
                        <div class="col-12 p-2">
                            <div class="p-2 border rounded">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6><i class="bi bi-caret-right"></i> I have no skills</h6>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>

                <div class="col-12 text-end">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-floppy"></i> Update Resume</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Experience Modal -->
<div class="modal fade" id="addexp" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Experience</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="actions/addexperience.action.php" class="row g-3">
                    <input type="hidden" name="resume_id" value="<?=$resume['id']?>">
                    <input type="hidden" name="slug" value="<?=$resume['slug']?>">
                    <div class="col-12">
                        <label for="inputEmail4" class="form-label">Position / Job Role</label>
                        <input type="text" class="form-control" name="position" placeholder="Job role" id="inputEmail4" required>
                    </div>
                    <div class="col-12">
                        <label for="inputPassword4" class="form-label">Company</label>
                        <input type="text" name="company" placeholder="Company name" class="form-control" id="inputPassword4" required>
                    </div>
                    <div class="col-md-6">
                        <label for="inputPassword4" class="form-label">Joined</label>
                        <input type="text" name="started" placeholder="Start date" class="form-control" id="inputPassword4" required>
                    </div>
                    <div class="col-md-6">
                        <label for="inputPassword4" class="form-label">Resigned</label>
                        <input type="text" name="ended" class="form-control" placeholder="Currently Pursuing/End date" id="inputPassword4" required>
                    </div>
                    <div class="col-12">
                        <label for="inputPassword4" class="form-label">Job Description</label>
                        <textarea class="form-control" name="job_desc" required></textarea>
                    </div>
                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-primary">Add Experience</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Education Modal -->
<div class="modal fade" id="addedu" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Education</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="actions/addeducation.action.php" class="row g-3" onsubmit="return validateEducation()">
                    <input type="hidden" name="resume_id" value="<?=$resume['id']?>">
                    <input type="hidden" name="slug" value="<?=$resume['slug']?>">
                    <div class="col-12">
                        <label class="form-label">Course / Degree</label>
                        <input type="text" class="form-control" name="course" placeholder="Stream" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Institute / Board</label>
                        <input type="text" name="institute" placeholder="Institute" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Start Year</label>
                        <input type="number" name="started" class="form-control edu-year" min="1900" max="2025" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">End Year</label>
                        <select name="ended_type" id="endedType" class="form-select" onchange="toggleEndYearInput()" required>
                            <option value="">Select Status</option>
                            <option value="completed">Completed</option>
                            <option value="present">Currently Pursuing</option>
                        </select>
                        <input type="number" name="ended" id="endYearInput" class="form-control mt-2" min="1900" max="2025" style="display:none;" placeholder="End Year">
                    </div>
                    <div class="col-12" id="gradeTypeContainer">
                        <label class="form-label">Grade Type (Optional if Pursuing)</label>
                        <select name="grade_type" class="form-select" id="gradeType" onchange="updateGradeInput()">
                            <option value="">Select Grade Type</option>
                            <option value="grade">Grade</option>
                            <option value="marks">Marks (%)</option>
                            <option value="cgpa">CGPA</option>
                        </select>
                    </div>
                    <div class="col-12" id="gradeInputContainer">
                        <label class="form-label">Grade/Marks/CGPA (Optional if Pursuing)</label>
                        <input type="text" name="grade" id="gradeInput" class="form-control">
                    </div>
                    <div id="eduError" class="text-danger" style="display:none"></div>
                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-primary">Add Education</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Skill Modal -->
<div class="modal fade" id="addskill" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Skill</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="actions/addskill.action.php" class="row g-3">
                    <input type="hidden" name="resume_id" value="<?=$resume['id']?>">
                    <input type="hidden" name="slug" value="<?=$resume['slug']?>">
                    <div class="col-12">
                        <label for="inputEmail4" class="form-label">Skill</label>
                        <input type="text" class="form-control" name="skill" placeholder="Basic Knowledge in Computer & Internet" id="inputEmail4" required>
                    </div>
                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-primary">Add Skill</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require './assets/includes/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

<script>
function toggleEndYearInput() {
    const endedType = document.getElementById('endedType').value;
    const endYearInput = document.getElementById('endYearInput');
    const gradeTypeContainer = document.getElementById('gradeTypeContainer');
    const gradeInputContainer = document.getElementById('gradeInputContainer');
    const gradeType = document.getElementById('gradeType');
    const gradeInput = document.getElementById('gradeInput');

    if (endedType === 'completed') {
        endYearInput.style.display = 'block';
        endYearInput.required = true;
        gradeTypeContainer.style.display = 'block';
        gradeInputContainer.style.display = 'block';
        gradeType.required = true;
        gradeInput.required = true;
    } else if (endedType === 'present') {
        endYearInput.style.display = 'none';
        endYearInput.required = false;
        endYearInput.value = '';
        gradeTypeContainer.style.display = 'block';
        gradeInputContainer.style.display = 'block';
        gradeType.required = false;
        gradeInput.required = false;
        gradeType.value = '';
        gradeInput.value = '';
    } else {
        endYearInput.style.display = 'none';
        gradeTypeContainer.style.display = 'block';
        gradeInputContainer.style.display = 'block';
    }
}

function updateGradeInput() {
    const gradeType = document.getElementById('gradeType').value;
    const gradeInput = document.getElementById('gradeInput');
    
    if (gradeType === 'grade') {
        gradeInput.placeholder = "Enter grade (e.g., A+, B)";
        gradeInput.type = 'text';
    } else if (gradeType === 'marks') {
        gradeInput.placeholder = "Enter percentage (0-100)";
        gradeInput.type = 'number';
        gradeInput.min = '0';
        gradeInput.max = '100';
    } else if (gradeType === 'cgpa') {
        gradeInput.placeholder = "Enter CGPA (0-10)";
        gradeInput.type = 'number';
        gradeInput.min = '0';
        gradeInput.max = '10';
    } else {
        gradeInput.placeholder = "Select grade type first";
        gradeInput.type = 'text';
    }
}

function validateEducation() {
    const startYear = parseInt(document.querySelector('input[name="started"]').value);
    const endedType = document.getElementById('endedType').value;
    const endYearInput = document.getElementById('endYearInput');
    const endYear = endedType === 'completed' ? parseInt(endYearInput.value) : 'Present';
    const gradeType = document.getElementById('gradeType').value;
    const grade = document.getElementById('gradeInput').value;
    const errorDiv = document.getElementById('eduError');
    
    errorDiv.style.display = 'none';
    errorDiv.textContent = '';

    if (endedType === 'completed' && (!endYear || endYear < startYear)) {
        errorDiv.textContent = 'End year must be greater than or equal to start year';
        errorDiv.style.display = 'block';
        return false;
    }

    const existingYears = <?php echo json_encode(array_map(function($edu) {
        return [$edu['started'], $edu['ended']];
    }, $edus)); ?>;
    
    for (let years of existingYears) {
        const existingStart = parseInt(years[0]);
        const existingEnd = years[1] === 'Present' ? 'Present' : parseInt(years[1]);
        if ((endYear !== 'Present' && (startYear === existingStart || endYear === existingEnd)) ||
            (endYear === 'Present' && startYear === existingStart)) {
            errorDiv.textContent = 'Education years must be unique from existing entries';
            errorDiv.style.display = 'block';
            return false;
        }
    }

    if (endedType === 'completed' && (!gradeType || !grade)) {
        errorDiv.textContent = 'Grade type and grade are required for completed education';
        errorDiv.style.display = 'block';
        return false;
    }

    if (endedType === 'completed' && gradeType && grade) {
        if (gradeType === 'marks') {
            const marks = parseFloat(grade);
            if (isNaN(marks) || marks < 0 || marks > 100) {
                errorDiv.textContent = 'Marks must be between 0 and 100';
                errorDiv.style.display = 'block';
                return false;
            }
        } else if (gradeType === 'cgpa') {
            const cgpa = parseFloat(grade);
            if (isNaN(cgpa) || cgpa < 0 || cgpa > 10) {
                errorDiv.textContent = 'CGPA must be between 0 and 10';
                errorDiv.style.display = 'block';
                return false;
            }
        } else if (gradeType === 'grade') {
            const validGrades = ['A+', 'A', 'B+', 'B', 'C+', 'C', 'D', 'F'];
            if (!validGrades.includes(grade.toUpperCase())) {
                errorDiv.textContent = 'Grade must be one of: A+, A, B+, B, C+, C, D, F';
                errorDiv.style.display = 'block';
                return false;
            }
        }
    }

    return true;
}

document.querySelectorAll('.edu-year, #gradeInput, #endedType').forEach(input => {
    input.addEventListener('change', validateEducation);
});
</script>
</body>
</html>