$(function () {

    let releaseButton = document.querySelector('#wyszukajZnajomego');
    releaseButton.addEventListener('keyup', function search() {
        let friendlist = document.querySelectorAll(".name2");
        // let friendlistItems = document.querySelectorAll(".wrap");
        let friendlistItemsAll = document.querySelectorAll(".contact3");
        // let friendlistItemsAll2 = document.querySelectorAll(".contact3");
        let j = 0;
        let item = "";
        let x = [];
        let sliceItem = "";
        for (let i = 0; i < friendlistItemsAll.length; i++) {
            x[i] = [];
        }
        let releaseButtonValue = releaseButton.value;
        let releaseButtonSplit = releaseButtonValue.split('');
        let releaseButtonLength = releaseButtonSplit.length;
        // let contacts = document.querySelector("#contacts");
        friendlistItemsAll.forEach(function (userItem) {

            if (releaseButtonLength == 0) {
                userItem.style.display = "block";
            }
            else {
                item = friendlist[j].outerText;
                item.split('');
                sliceItem = item.slice(0, releaseButtonLength)
                if (sliceItem != releaseButton.value) {
                    userItem.style.display = "none";
                }
                j += 1;
            }

        });
    });
});



$(function () {

    let utworzGrupeBtn = document.querySelector("#utworz_grupe");
    utworzGrupeBtn.addEventListener('click', function () {
        let groupNewName = document.querySelector('#nazwa_nowej_grupy').value;
        let grupy = document.querySelectorAll('.grupyelement');
        grupy.forEach(function (groupName) {
            if (groupNewName == groupName.outerText) {
                $.notify("Grupa o ponanej nazwie istnieje", "warning");
            }
        });

    });
});


// $(function () {

//     let przycisk = document.querySelector("#contacts");
 
//     przycisk.addEventListener('click', function () {
//         let nazwaPliku = document.querySelectorAll(".messageLinks");
//         // console.log(nazwaPliku);
//         // nazwaPliku[0].outerText = "ELO"
//         nazwaPliku.forEach(function (plikName) {
             
//             plikName.href = "plikBozy";

//         });
//     });

// });

