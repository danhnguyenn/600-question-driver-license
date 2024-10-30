const question = document.getElementById("title");
const answers = document.querySelectorAll(".answer");
const quiz =  document.getElementById("question")
const sbBtn = document.getElementById("btnNext");
let current_answer = 0;
let grade = 0;
let countAnswerCorrect = 0;

function loadQuestion() {
  sbBtn.disabled = true;
  removeAnswer()
  fetch("http://localhost/restful-api-php/api/question/read.php")
    .then((res) => res.json())
    .then((data) => {
      console.log(data)
      document.getElementById("answer-count").value = data.questions.length
      const answer_a = document.getElementById("answer_a");
      const answer_b = document.getElementById("answer_b");
      const answer_c = document.getElementById("answer_c");
      const answer_d = document.getElementById("answer_d");

      const getQuestion = data.questions[current_answer];

      question.innerText = getQuestion.title;
      answer_a.innerText = getQuestion.question_a;
      answer_b.innerText = getQuestion.question_b;
      if (getQuestion.question_c && getQuestion.question_c.trim() !== "") {
        document.getElementById("question-d").classList.add("hienthicautraloi");
        answer_c.innerText = getQuestion.question_c;
      } else {
        document
          .getElementById("question-c")
          .classList.addClass("hienthicautraloi");
      }

      if (getQuestion.question_d && getQuestion.question_d.trim() !== "") {
        document.getElementById("question-c").classList.remove("hienthicautraloi");
        answer_d.innerText = getQuestion.question_d;
      } else {
        document.getElementById("question-d").classList.add("hienthicautraloi");
      }
      document.getElementById("answer-correct").value = getQuestion.question_correct;
    })
    .catch((err) => console.log(err));
}

loadQuestion();

// Chọn câu trả lời
function getAnswer(){
  let answer = undefined;
  answers.forEach((traloi)=> {
    if(traloi.checked){
      answer = traloi.id;
    }
  })

  return answer;
}

// bỏ câu trả lời
function removeAnswer() {
  answers.forEach((answer)=> {
    answer.checked = false;
})
}

checkNextQuestion();

function checkNextQuestion(){
  answers.forEach(ans => {
    ans.addEventListener('change', (e)=> {
      sbBtn.removeAttribute("disabled");
    })
  })
}


// Submit
sbBtn.addEventListener("click", () => {
  const answer = getAnswer();
  if(answer){
    if(answer === document.getElementById("answer-correct").value){
        grade++
    }
  }

  current_answer++;
  loadQuestion();

  if(current_answer < document.getElementById("answer-count").value){
    loadQuestion();
  } else {
    const sumAnswerCorrect = document.getElementById("answer-count").value
    quiz.innerHTML = `<h2>
          Bạn đã đúng ${grade} / ${sumAnswerCorrect} câu hỏi </h2>
          <button onclick="location.reload()">Làm lại bài</button>
    </h2>`
  }
});
