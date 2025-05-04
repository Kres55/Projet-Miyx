const search = document.getElementById('search');
const results = document.getElementById('results');
search.addEventListener("input", function (e) {
    //JE REcupere la valeure de ce que j'écris
    //let v = e.target.value
    //on peut ecrire aussi : 
    let v = this.value;
    const formData = new FormData;
    //grace au formData, dans le back end pour recuperer la valeure de recherche, j'aurais
    //juste besoin de faire $_POST["search"]
    formData.append("search", v)

    data = {
        method: "POST",
        body: formData,
        headers: {
            "Accept": "application/json"
        }
    }

    //Je prepare mon AJAX

    fetch("controller/search.php", data)
        .then(response => response.json())
        .then(res => {
            // console.log(res);
            results.innerHTML = "";

            for (let music of res) {
                const li = document.createElement('li');
                li.classList.add("list-group-item");
                li.classList.add("liste");
                li.innerHTML = `<span class="scale-text">${music.music_track} par ${music.user_artistname}</span>`;


                li.style.cursor = "pointer";

                li.addEventListener("click", () => {
                    // Rediriger vers une nouvelle URL avec l'ID de la musique
                    window.location.href = `view/homepage.php?id=${music.music_id}`;
                });

                results.appendChild(li);
            }
        });

})
