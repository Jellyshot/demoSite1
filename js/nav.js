'use strinct';

function myFunction() {
    let x = document.getElementById("myLinks");
    if (x.style.display === "block") {
    // '=='는 값만 같으면 동일하게 처리하지만, '==='는 값뿐만이 아니라 타입까지 같아야 동일한것으로 본다.
    x.style.display = "none";
    } else {
        x.style.display = "block";
    }
}