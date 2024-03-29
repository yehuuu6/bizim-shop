import axios from 'axios';

const productId = (
  document.querySelector('.product-container') as HTMLDivElement
).dataset.id;
const qForm = document.querySelector('.ask-question') as HTMLFormElement;
const qWrapper = document.querySelector('.see-questions') as HTMLDivElement;
const qContainer = qWrapper.querySelector('.questions') as HTMLDivElement;
const noQuestions = qWrapper.querySelector('#no-question') as HTMLDivElement;
const loadMoreBtn = qWrapper.querySelector(
  '.load-more-questions'
) as HTMLButtonElement;
const charCounter = qForm.querySelector('.character-count') as HTMLSpanElement;

let offset = 0;

window.addEventListener('scroll', () => {
  const godWrapper = document.querySelector(
    '.questions-wrapper'
  ) as HTMLDivElement;
  const stickyPoint = godWrapper.offsetTop;
  const bottomLimit = godWrapper.offsetTop + godWrapper.offsetHeight;

  if (
    window.scrollY >= stickyPoint &&
    window.scrollY + qForm.offsetHeight < bottomLimit
  ) {
    qForm.classList.add('sticky');
  }
});

async function makeRequest(url: string, data: any) {
  return await axios({
    url,
    method: 'POST',
    data,
    headers: {
      'X-Requested-With': 'XMLHttpRequest',
      'Content-Type': 'multipart/form-data',
    },
  });
}

async function listenFormToSaveQuestion() {
  qForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    const question = (qForm.querySelector('textarea') as HTMLTextAreaElement)
      .value;
    if (question.trim() === '') {
      console.log('Please fill in all fields');
      return;
    }
    const response = await makeRequest('/api/questions/save-question.php', {
      id: productId,
      question,
    });
    const [status, message, cause] = response.data;
    if (status === 'error') {
      console.log(message, cause);
    } else if (status === 'success') {
      console.log(message);
      offset = 0;
      getQuestions();
      loadMoreBtn.disabled = false;
      loadMoreBtn.innerText = 'Daha fazla soru gör';
    }
    (qForm.querySelector('textarea') as HTMLTextAreaElement).value = '';
    charCounter.textContent = '0/550';
    window.scrollTo({ top: qWrapper.offsetTop, behavior: 'smooth' });
  });
}

async function getQuestions(reset_old_html: boolean = true) {
  const response = await makeRequest('/api/questions/get-questions.php', {
    id: productId,
    offset,
  });
  const questions = response.data;
  if (questions.length === 0) {
    noQuestions.style.display = 'flex';
    loadMoreBtn.disabled = true;
    loadMoreBtn.innerText = 'Daha fazla soru yok';
  } else {
    noQuestions.style.display = 'none';
    loadMoreBtn.style.display = 'block';
  }
  if (reset_old_html) qContainer.innerHTML = noQuestions.outerHTML;
  for (const question of questions) {
    qContainer.innerHTML += question;
  }
  offset += questions.length;
  listenQuestionDeleteClicks();
}

async function deleteQuestion(id: string) {
  const response = await makeRequest('/api/questions/delete-question.php', {
    id,
  });
  console.log(response.data);
  const [status, message] = response.data;
  if (status === 'error') {
    console.log(message);
  } else if (status === 'success') {
    console.log(message);
    offset = 0;
    getQuestions();
  }
}

function listenQuestionDeleteClicks() {
  const deleteBtns = qContainer.querySelectorAll(
    '.delete-question'
  ) as NodeListOf<HTMLDivElement>;
  deleteBtns.forEach((btn) => {
    btn.addEventListener('click', () => {
      const id = btn.dataset.questionId as string;
      deleteQuestion(id);
    });
  });
}

export function initQuestions() {
  qForm.addEventListener('input', () => {
    const textarea = (qForm.querySelector('textarea') as HTMLTextAreaElement)
      .value;
    charCounter.textContent = `${textarea.length}/550`;
  });
  loadMoreBtn.addEventListener('click', () => getQuestions(false));
  listenFormToSaveQuestion();
  getQuestions();
}
