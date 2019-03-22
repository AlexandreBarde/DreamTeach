function clicked()
{
    this.setAttribute('disabled', "");
    $.ajax({
        url: "{{ path('CheckWord') }}",
        type: "POST",
        dataType: "json",
        data: {
            "char": this.firstChild.textContent
        },
        async: true,
        success: function (data)
        {
            let state = JSON.stringify(data['word']);
            let life = JSON.stringify(data['life']);
            let definition = JSON.stringify(data['definition']);
            let position = (data['position']);
            let letter = (data['letter']);
            let winner = data['winner'];
            if(winner)
            {
                window.location.replace("{{ path('HangmanWinner') }}");
                alert("super mec !");
            }
            if(position.length !== 0)
            {
                let wordSecret = $("#word").html();
                for(let i = 0; i < position.length; i++)
                {
                    wordSecret = (wordSecret.substring(0, position[i]) +
                        letter + wordSecret.substring((position[i] + 1), wordSecret.length));
                }
                $("#word").html(wordSecret);
            }
            if(life === "0") alert("Vous avez perdu !");
            if(definition !== "null") $("#definition").html(definition);
            $("#nbrEssais").html(life);
        }
    });
}


var alphabet = ["a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z"];
for(i = 0;  i < alphabet.length; i++)
{
    if(i % 6 === 0 )
    {
        var br = document.createElement("br");
        document.getElementById("alphabet").appendChild(br);
    }
    var btn = document.createElement("BUTTON");
    btn.setAttribute("class", "pr-2 pl-2 text-center letter");
    var t = document.createTextNode(alphabet[i]);
    btn.addEventListener("click", clicked);
    btn.appendChild(t);
    document.getElementById("alphabet").appendChild(btn);
}