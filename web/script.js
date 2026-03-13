window.onload = loadJsItem();
document.querySelectorAll(".zoomPoster").forEach(image => {
    image.addEventListener("click", function() {
        document.getElementById("modal").style.display = "block";
        document.getElementById("modalImg").setAttribute("src", image.getAttribute("src"));
    });
});
document.getElementById("modal").addEventListener("click", function(event){
    if(event.target == document.getElementById("modal"))
    {
        document.getElementById("modal").style.display = "none";
    }
});
document.getElementById("close").addEventListener("click", function(){
        document.getElementById("modal").style.display = "none";
});

function loadJsItem(){
    let item = document.getElementById("jsItem");
    item.id = "dialog";
    item.style.display = "block";
}