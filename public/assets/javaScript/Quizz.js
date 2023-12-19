document.addEventListener('DOMContentLoaded', function() {
    const questions = [
        {
            question: 'Combien y a-t-il de joueurs dans une équipe de hockey sur glace ?',
            options: ['10', '20', '30'],
            answer: '20'
        },
        {
            options: ['trois périodes de 15 minutes chacune, avec une pause de 20 minutes entre chaque période.','trois périodes de 20 minutes chacune, avec une pause de 15 minutes entre chaque période.','deux périodes de 20 minutes chacune, avec une pause de 15 minutes entre chaque période.'],
            answer: 'trois périodes de 20 minutes chacune, avec une pause de 15 minutes entre chaque période.'
        },
    ];

    const quizForm = document.getElementById('quiz-form');
    const questionContainer = document.getElementById('question-container');
    let questionIndex = 0;

    function displayQuestion() {
        const currentQuestion = questions[questionIndex];
        const questionMarkup = `
            <h2>Question ${questionIndex + 1}</h2>
            <p>${currentQuestion.question}</p>
            <ul>
                ${currentQuestion.options.map(option => `<li><input type="radio" name="reponse" value="${option}"> ${option}</li>`).join('')}
            </ul>
        `;
        questionContainer.innerHTML = questionMarkup;
    }

    displayQuestion();

    quizForm.addEventListener('submit', function(event) {
        event.preventDefault();

        const selectedAnswer = document.querySelector('input[name="reponse"]:checked');

        if (selectedAnswer) {
            const userAnswer = selectedAnswer.value;

            // Vérification de la réponse
            if (userAnswer === questions[questionIndex].answer) {
                alert('Bonne réponse !');
            } else {
                alert('Mauvaise réponse.');
            }

            questionIndex++;

            if (questionIndex < questions.length) {
                displayQuestion();
            } else {
                alert('Vous avez terminé le quiz !');
            }
        } else {
            alert('Veuillez sélectionner une réponse.');
        }
    });
});
