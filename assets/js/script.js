/* start navbar */
console.log("Script loaded!");

// flash message 


document.addEventListener("DOMContentLoaded", function () {
    const menuBtn = document.getElementById("menu-btn");
    const mobileMenu = document.getElementById("mobilemenu");

    menuBtn.addEventListener("click", () => {
        menuBtn.classList.toggle("crossx");
        if (mobileMenu.classList.contains("hidden")) {
            mobileMenu.classList.remove("hidden");
        } else {
            mobileMenu.classList.add("hidden");
        }
    });
});



// Password visibility toggle
document.querySelectorAll('.fa-eye-slash').forEach(icon => {
    icon.addEventListener('click', function (e) {
        const input = this.closest('div').previousElementSibling;
        const type = input.type === 'password' ? 'text' : 'password';
        input.type = type;
        this.classList.toggle('fa-eye-slash');
        this.classList.toggle('fa-eye');
    });
});

// start accordion
const getacctitle = document.getElementsByClassName("acctitle");
const getacccontent = document.querySelectorAll('.acccontent');
// console.log('hay');
for (let x = 0; x < getacctitle.length; x++) {
    // console.log(x);
    getacctitle[x].addEventListener('click', function (e) {
        this.classList.toggle('active');

        const getcontent = this.nextElementSibling;
        // console.log(getcontent);
        if (getcontent.style.height) {
            getcontent.style.height = null;
        } else {
            getcontent.style.height = getcontent.scrollHeight + "px";
        }
    });
}
// end accordion

// Open Login Modal
function openLoginModal() {
    document.getElementById("login-modal").style.display = "block";
}

// Close Login Modal
function closeLoginModal() {
    document.getElementById("login-modal").style.display = "none";
}

// Open Join Up Modal
function openJoinUpModal() {
    document.getElementById("joinup-modal").style.display = "block";
}

// Close Join Up Modal
function closeJoinUpModal() {
    document.getElementById("joinup-modal").style.display = "none";
}


window.switchToSignUp = function () {
    closeLoginModal();
    openJoinUpModal();
};

window.switchToLogin = function () {
    closeJoinUpModal();
    openLoginModal();
};


// console.log(typeof switchToLogin);
// console.log(typeof switchToSignUp);
// end join up pop up

// start timeline 

const getboxes = document.querySelectorAll(".boxes");
// console.log(getboxes);
// console.log(getboxes[10]);

for (var x = 0; x, getboxes.length; x++) {
    // console.log(x); //0  to 5
    getboxes[x].addEventListener('click', function () {
        console.log(this);
        if (this.classList.contains("left")) {
            this.classList.remove("left");
            this.classList.add("right");
        } else {
            this.classList.remove("right");
            this.classList.add("left");
        }
    });
}
// end timeline 



