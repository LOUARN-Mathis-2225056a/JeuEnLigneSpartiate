const questions = [
    {
        question: 'Combien y a-t-il de joueurs dans une équipe de hockey sur glace ?',
        bonneReponse: '6',
    },
    {
        question: 'Quelle est la durée d\'un match de hockey sur glace ?',
        bonneReponse: 'trois périodes de 20 minutes chacune, avec une pause de 15 minutes entre chaque période.',
    },
];

let reponseCorrecte = questions[questionCourante].bonneReponse;

let score = 0;
function valider() {
    const reponse = document.querySelector('input[name="reponse"]:checked').value;

    if (reponse === '') {
        alert('Veuillez sélectionner une réponse.');
        return;
    }

    if (reponse === reponseCorrecte) {
        score++;
    }

    questionCourante++;

    if (questionCourante === questions.length) {
        alert('Le quiz est terminé. Votre score est de ' + score + '.');
        return;
    }

    // Pour afficher la deuxième question
    questionCourante = 1;

    document.querySelector('.score').textContent = score;
}

let questionCourante = 1;

document.querySelector('button[type="submit"]').addEventListener('click', valider);
