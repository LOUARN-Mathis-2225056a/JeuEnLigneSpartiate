const sleepNow = (delay) => new Promise((resolve) => setTimeout(resolve, delay))

async function spriteShootingAnimation() {
    var tireur = document.getElementById("spriteTireur");
    var time = 150;

    tireur.src = "../../../public/assets/ressources/sprites/AttaquantHockey_Frame2_and_6.png";
    await sleepNow(time);
    tireur.src = "../../../public/assets/ressources/sprites/AttaquantHockey_Frame3_and_5.png";
    await sleepNow(time);
    tireur.src = "../../../public/assets/ressources/sprites/AttaquantHockey_Frame4.png";
    await sleepNow(time);
    tireur.src = "../../../public/assets/ressources/sprites/AttaquantHockey_Frame3_and_5.png";
    await sleepNow(time);
    tireur.src = "../../../public/assets/ressources/sprites/AttaquantHockey_Frame2_and_6.png";
    await sleepNow(time);
    tireur.src = "../../../public/assets/ressources/sprites/AttaquantHockey_Frame1_and_7.png";
    await sleepNow(time);
    tireur.src = "../../../public/assets/ressources/sprites/AttaquantHockey_Frame8.png";
}