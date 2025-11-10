const questions = [
    {
        question: "1. Como você reage quando seu filho comete um erro?",
        options: {
            a: "Aplico uma punição para que ele aprenda a lição.",
            b: "Tento conversar, mas acabo deixando passar.",
            c: "Não costumo me envolver muito nessas situações.",
            d: "Explico o erro e ajudo meu filho a entender as consequências.",
        },
    },
    {
        question: "2. Como você lida com regras em casa?",
        options: {
            a: "Tenho regras rígidas e não permito questionamentos.",
            b: "Tenho poucas regras, quero que meu filho tenha liberdade.",
            c: "Não estabeleço muitas regras, cada um faz o que quiser.",
            d: "Tenho regras claras, mas estou aberto ao diálogo.",
        },
    },
    {
        question: "3. O que você faz quando seu filho quer algo que não pode ter?",
        options: {
            a: "Digo “não” e não permito discussão.",
            b: "Muitas vezes cedo para evitar conflitos.",
            c: "Normalmente, nem percebo o que ele quer.",
            d: "Explico os motivos e, se possível, busco uma alternativa.",
        },
    },
    {
        question: "4. Como você participa da vida escolar do seu filho?",
        options: {
            a: "Exijo notas altas e disciplina, sem desculpas.",
            b: "Não cobro muito, quero que ele aproveite a infância.",
            c: "Não acompanho de perto, deixo que ele se vire sozinho.",
            d: "Acompanho, incentivo e ajudo quando necessário.",
        },
    },
    {
        question: "5. Como é a comunicação entre você e seu filho?",
        options: {
            a: "Eu mando e ele obedece.",
            b: "Falo pouco sobre assuntos difíceis, quero evitar brigas.",
            c: "Cada um vive sua vida, quase não conversamos.",
            d: "Conversamos abertamente sobre tudo.",
        },
    },
    {
        question: "6. Como você lida com birras ou comportamentos inadequados?",
        options: {
            a: "Dou uma punição imediata para ele aprender.",
            b: "Tento acalmar, mas acabo deixando passar.",
            c: "Geralmente, não interfiro.",
            d: "Tento entender o motivo e ensinar uma melhor forma de agir.",
        },
    },
    {
        question: "7. Como você reage quando seu filho pede sua atenção enquanto você está ocupado?",
        options: {
            a: "Digo que ele deve esperar e não interromper.",
            b: "Paro tudo o que estou fazendo para atender.",
            c: "Normalmente, não percebo ou ignoro.",
            d: "Peço para esperar um pouco e depois dou atenção.",
        },
    },
    {
        question: "8. Como você incentiva a independência do seu filho?",
        options: {
            a: "Tomo todas as decisões para ele, pois sei o que é melhor.",
            b: "Deixo ele fazer tudo o que quiser.",
            c: "Não me envolvo muito nas escolhas dele.",
            d: "Dou espaço para ele decidir, mas oriento quando necessário.",
        },
    },
    {
        question: "9. Como você lida com os sentimentos do seu filho?",
        options: {
            a: "Emoções não podem interferir na disciplina.",
            b: "Evito conflitos, não gosto de ver meu filho triste.",
            c: "Não costumo prestar atenção nisso.",
            d: "Valorizo e ajudo meu filho a entender e lidar com seus sentimentos.",
        },
    },
    {
        question: "10. Como você se vê como pai/mãe?",
        options: {
            a: "Sou exigente e disciplinador, pois quero que meu filho tenha sucesso.",
            b: "Quero que meu filho goste de mim, então evito ser rígido.",
            c: "Acho que meu filho deve se virar sozinho.",
            d: "Quero ser um guia e um apoio, sempre mantendo diálogo e respeito.",
        },
    }
];



const testquiz = document.getElementById("testquiz");
const finalquiz = document.getElementById("finalquiz");
// finalquiz.innerText = "";
const quizbtn = document.getElementById("startbtn");
const quizstart = document.getElementById("startquiz");
const questionElement = document.getElementById("question");
const optionsElement = document.getElementById("options");
const prevButton = document.getElementById("prev");
const nextButton = document.getElementById("next");

let currentQuestion = 0;
let letterCounts = { a: 0, b: 0, c: 0, d: 0 };
let selectedOptions = {};

function loadQuestion() {
    const questionData = questions[currentQuestion];
    questionElement.textContent = questionData.question;
    document.getElementById("option-a").textContent = questionData.options.a;
    document.getElementById("option-b").textContent = questionData.options.b;
    document.getElementById("option-c").textContent = questionData.options.c;
    document.getElementById("option-d").textContent = questionData.options.d;

    // Remove a classe 'active' das opções da pergunta anterior
    optionsElement.querySelectorAll(".option").forEach(option => {
        option.classList.remove("active");
    });

    // Adiciona a classe 'active' à opção selecionada (se houver)
    if (selectedOptions[currentQuestion]) {
        optionsElement.querySelector(`[data-choice="${selectedOptions[currentQuestion]}"]`).classList.add("active");
    }
}

function checkAnswer(choice) {
    letterCounts[choice]++;
    selectedOptions[currentQuestion] = choice;

    // Adiciona a classe 'active' à opção selecionada
    optionsElement.querySelectorAll(".option").forEach(option => {
        option.classList.remove("active");
    });
    event.target.classList.add("active");
}

function nextQuestion() {
    if (currentQuestion < questions.length - 1) {
        currentQuestion++;
        loadQuestion();

    } else {
        const mostFrequentLetter = Object.keys(letterCounts).reduce((a, b) => letterCounts[a] > letterCounts[b] ? a : b);

        var letra;
        switch (mostFrequentLetter) {
            case 'a':
                letra = "Estilo Autoritário";
                break;
            case 'b':
                letra = "Estilo Permissivo";
                break;
            case 'c':
                letra = "Estilo Negligente";
                break;
            case 'd':
                letra = "Estilo Participativo";
                break;
            default:
                letra = "Ops! Você não selecionou nenhuma resposta?"
                break;
        }

        Swal.fire({
            title: "Quiz finalizado!",
            html: `Resultado das suas respostas indica: <span style="font-size: 18px; color: #333; font-weight: bold; color: blue">${letra}</span> `,
            icon: "success",
            showConfirmButton: true,
            // timer: 3500,
            willClose: () => {

                testquiz.style.display = 'none';
                $.post('./forms/quiz01.php', function (retorna) {
                    console.log(retorna);
                    $("#finalquiz").html(retorna);
                    $('body').css('justify-content', 'flex-end');
                    // window.location.reload();
                });
            }
        });
    }
}

function prevQuestion() {
    if (currentQuestion > 0) {
        currentQuestion--;
        loadQuestion();
    }
}

optionsElement.addEventListener("click", (event) => {
    if (event.target.classList.contains("option")) {
        checkAnswer(event.target.dataset.choice);
    }
});

nextButton.addEventListener("click", nextQuestion);
prevButton.addEventListener("click", prevQuestion);

loadQuestion();