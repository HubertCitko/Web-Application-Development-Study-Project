const Titles = ["Demon Slayer: Mugen Train","Spider-Man: Into the Spider-Verse", "Interstellar"];
const Reviews = ["Demon Slayer: Mugen Train to pierwszy pełnometrażowy film anime z uniwersum Demon Slayer, będący kontynuacją serii, która zdobyła ogromną popularność zarówno w Japonii, jak i na świecie. Akcja filmu koncentruje się na podróży Tanjiro, Nezuko, Zenitsu i Inosuke na pokładzie tajemniczego Nieskończonego Pociągu , gdzie dochodzi do serii nadprzyrodzonych zdarzeń związanych z obecnością demona. Reżyser Haruo Sotozaki mistrzowsko łączy wartką akcję, głębokie emocje i dynamiczną animację, zwłaszcza w scenach walki, które robią ogromne wrażenie wizualne. Dodatkowo, relacje między bohaterami i ich wewnętrzne zmagania są przedstawione w niezwykle poruszający sposób. To film, który przypadnie do gustu zarówno fanom anime, jak i osobom szukającym porywającej historii o odwadze i poświęceniu.",
    "Spider-Man: Into the Spider-Verse to jedna z najbardziej oryginalnych produkcji animowanych, która ożywia historię Spider-Mana na zupełnie nowy sposób. Film przedstawia Milesa Moralesa, młodego chłopaka z Nowego Jorku, który odkrywa swoje nadludzkie zdolności i poznaje alternatywne wersje Spider-Mana z innych wymiarów. Reżyserzy Bob Persichetti, Peter Ramsey i Rodney Rothman stworzyli dzieło sztuki pełne intensywnych kolorów, dynamicznych efektów wizualnych i wyjątkowego stylu animacji przypominającego komiksowy świat. Film zachwyca również humorem, energią i innowacyjnością, wprowadzając temat odwagi, przyjaźni i odpowiedzialności. Spider-Verse to film, który redefiniuje, czym może być animacja w kinie i oferuje coś wyjątkowego zarówno dla młodszych, jak i starszych widzów.",
    "Interstellar to spektakularny film science fiction, wyreżyserowany przez Christophera Nolana, który zabiera widzów w emocjonalną i filozoficzną podróż przez kosmos. Fabuła koncentruje się na losach byłego pilota Coopera, który zostaje zwerbowany do misji ratunkowej mającej na celu znalezienie nowego domu dla ludzkości. Obraz ten jest zachwycający pod względem wizualnym, z niezwykle realistycznym odwzorowaniem przestrzeni kosmicznej oraz planet i czarnych dziur, które wydają się wręcz namacalne. Film w fascynujący sposób łączy naukę z emocjami, eksplorując zarówno tematy fizyki, jak i ludzkiej więzi. Oprawa muzyczna Hansa Zimmera dodaje całości monumentalnego, niemal mistycznego nastroju. Interstellar to dzieło głębokie i wzruszające, skłaniające do refleksji nad sensem czasu, miłości i naszego miejsca we wszechświecie."];
var displaying = false;
window.onload = displaySavedData();
function pickItem(item, number) {
    if(item.classList.contains("picked"))
    {
        item.classList.replace("picked", "notPicked");
        localStorage.clear();
        displaying = false;
        deleteBranch();
    }
    else
    {
        images = document.querySelectorAll(".picked");
        images.forEach(item_ => {
            item_.classList.replace("picked", "notPicked");
        });
        item.classList.replace("notPicked", "picked");
        localStorage.setItem("savedNumber", number);
        if(displaying == false){
            addBranch(Titles[number],Reviews[number]);
            displaying = true;
        }
        else
        {
            updateBranch(Titles[number],Reviews[number]);
        }
        
    }
}
function addBranch(MovieName, MovieReview){
    const newElement = document.createElement("h1");
    const newElement1 = document.createElement("p")
    newElement.innerHTML = MovieName;
    newElement1.innerHTML = MovieReview;
    document.getElementById("begin").appendChild(newElement);
    document.getElementById("begin").appendChild(newElement1);
}
function updateBranch(MovieName, MovieReview){
    const newElement =document.createElement("h1");
    const newElement1 = document.createElement("p")
    newElement.innerHTML = MovieName;
    newElement1.innerHTML = MovieReview;
    document.getElementById("begin").innerHTML = '';
    document.getElementById("begin").appendChild(newElement);
    document.getElementById("begin").appendChild(newElement1);
}
function deleteBranch(){
    document.getElementById("begin").innerHTML = '';
}
function displaySavedData(){
    if(localStorage.getItem("savedNumber") != null ){
        var localNum = localStorage.getItem("savedNumber");
        addBranch(Titles[localNum], Reviews[localNum]);
        displaying=true;
        document.getElementById("itemsContainer").getElementsByTagName("img")[localNum].classList.replace("notPicked", "picked");
}};