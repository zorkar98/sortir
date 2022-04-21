window.onload = () => {
    const FiltersForm = document.querySelector("#filters");

    //On boucle sur les input
    document.querySelectorAll("#filters input").forEach(input => {

        input.addEventListener("change", ()=> {
            //Ici on intercepte les clics

            //On reccupere les données du form
            const Form = new FormData(FiltersForm);

            //On fabrique la "querystring
            const Params = new URLSearchParams();

            Form.forEach((value ,key) => {
                Params.append(key, value);
            });

            //On récupère l'url active
            const Url = new URL(window.location.href)

            //On lance la requete ajax
            fetch(Url.pathname+"?"+Params.toString()+"&ajax=1",{
                headers: {
                    "X-Requested-With": "XMLHttpRequest"
                }
            }).then(response =>
                response.json()
            ).then(data => {
                //On va chercher la zone de contenu
                const content = document.getElementById("content");

                //On remplace le contenu
                content.innerHTML = data.content;
            }).catch(e=>alert(e));

        });
    });
}