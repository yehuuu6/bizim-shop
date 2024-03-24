import PanelClass from '@/classes/PanelController';
import { IQuestion } from '@/common/interfaces/utility/IQuestion';

const rowNumberQuestions = {
  value: 0,
};

const currentQuestions: { value: IQuestion[] } = {
  value: [],
};

let sqlOffset = 0;
let questionLimit = 30;

const questionMore = document.querySelector(
  '#load-more-questions'
) as HTMLButtonElement;
const questionTable = document.querySelector(
  '#questions-table tbody'
) as HTMLTableSectionElement;
const questionLoader = document.querySelector(
  '#loader-questions'
) as HTMLDivElement;
const questionRefresh = document.querySelector(
  '#refresh-questions'
) as HTMLButtonElement;
const searchInput = document.querySelector(
  '#search-question'
) as HTMLInputElement;

function setStatus(status: string) {
  switch (status) {
    case '0':
      return 'Cevaplanmadı';
    case '1':
      return 'Cevaplandı';
    default:
      return 'Hata';
  }
}

const ManageQuestionsPage = new PanelClass(questionLoader);

function createQuestionTable(question: IQuestion) {
  // Create table row
  const tr = document.createElement('tr');

  const date = new Date(question.date).toLocaleDateString('tr-TR', {
    day: 'numeric',
    month: 'long',
    year: 'numeric',
  });
  tr.innerHTML = `
            <td>${++rowNumberQuestions.value}</td>
            <td>${question.username}</td>
            <td><a href="http://localhost/product/${
              question.link
            }" target="_blank">${question.product}</a></td>
            <td>${date}</td>
            <td>${setStatus(question.status)}</td>
            <td class="table-form-td">
                <form class="table-form" data-id="${question.id}">
                    <button data-action="upgrade" class="dashboard-btn status-btn">İncele</button>
                </form>
            </td>
        `;
  const tableForm = tr.querySelector('.table-form') as HTMLElement;
  tableForm.addEventListener('click', (e) => {
    e.preventDefault();
    if ((e.target as HTMLElement).dataset.action == 'upgrade') {
      // Get the id of the question
      let id = ((e.target as HTMLElement).parentElement as HTMLElement).dataset
        .id;
      // Get the question from the currentQuestions array
      let question = currentQuestions.value.find(
        (question: IQuestion) => question['id'] == id
      );
      ManageQuestionsPage.showMessage([
        'success',
        `${question?.id} isimli soru modalı yapılacak. (TODO)`,
        'none',
      ]);
    } else if ((e.target as HTMLElement).dataset.action == 'ban') {
      // Get the id of the question
      let id = ((e.target as HTMLElement).parentElement as HTMLElement).dataset
        .id;
      // Get the plugin from the currentQuestions array
      let question = currentQuestions.value.find(
        (question: IQuestion) => question['id'] == id
      );
      ManageQuestionsPage.showMessage([
        'success',
        `${question?.id} isimli kullanıcı yasaklandı. (TODO)`,
        'none',
      ]);
    }
  });

  return tr;
}

let oldSearch = '';

function getSearchQuestion() {
  const search = searchInput.value.trim().toLowerCase();

  if (search === oldSearch) {
    return;
  } else if (search.length <= 0) {
    loadFirstQuestions();
    oldSearch = search;
    return;
  }

  questionMore.classList.add('disabled');
  questionMore.disabled = true;

  sqlOffset = 0;

  oldSearch = search;

  const formData = new FormData();
  formData.append('search', search);
  formData.append('offset', '0');
  formData.append('limit', questionLimit.toString());

  ManageQuestionsPage.sendApiRequest(
    '/api/dashboard/questions/load-questions.php',
    formData
  ).then((response) => {
    let questions = response;
    if (questions === undefined || questions.length === 0) {
      questionTable.innerHTML = '';
      questionTable.innerHTML = `
        <tr>
          <td colspan="6">Soru bulunamadı.</td>
        </tr>
      `;
      return;
    }
    rowNumberQuestions.value = 0;
    currentQuestions.value = questions;
    questionTable.innerHTML = '';

    questions.forEach((question: IQuestion) => {
      questionTable.appendChild(createQuestionTable(question));
    });
  });
}

function debounce(callback: any, delay: number) {
  let timer: any;
  return function () {
    clearTimeout(timer);
    timer = setTimeout(callback, delay);
  };
}

function runSearchQuestions(searchQuestionInput: HTMLInputElement) {
  let questionSearchInterval: any = null;
  // Set interval on focus to search input and clear it when it's not focused
  searchQuestionInput.addEventListener('focus', () => {
    if (!questionSearchInterval) {
      questionSearchInterval = setInterval(() => {
        getSearchQuestion();
      }, 300); // Throttle the calls to every 300 milliseconds
    }
  });

  searchQuestionInput.addEventListener('blur', () => {
    clearInterval(questionSearchInterval);
    questionSearchInterval = null; // Reset the interval variable
  });

  searchQuestionInput.addEventListener(
    'input',
    debounce(() => {
      getSearchQuestion();
    }, 300)
  ); // Debounce the input event to trigger after the user stops typing
}

async function loadFirstQuestions() {
  sqlOffset = 0;
  searchInput.value = '';
  rowNumberQuestions.value = 0;
  currentQuestions.value = [];
  questionTable.innerHTML = '';
  questionMore.classList.remove('disabled');
  questionMore.disabled = false;

  const formData = new FormData();
  formData.append('offset', '0');
  formData.append('limit', questionLimit.toString());
  const response = await ManageQuestionsPage.sendApiRequest(
    '/api/dashboard/questions/load-questions.php',
    formData
  );

  const questions = response;

  if (questions === undefined || questions.length === 0) {
    questionTable.innerHTML = `
      <tr>
        <td colspan="6">Soru bulunamadı.</td>
      </tr>
    `;
    return;
  }

  if (questions !== undefined || questions.length !== 0) {
    questions.forEach((question: IQuestion) => {
      currentQuestions.value.push(question);
      questionTable.appendChild(createQuestionTable(question));
    });
  }
}

function refreshQuestions() {
  loadFirstQuestions();
}

questionRefresh.addEventListener('click', refreshQuestions);
(
  document.querySelector('div[data-name="questions"]') as HTMLDivElement
).addEventListener('click', () => {
  refreshQuestions();
});

questionMore.addEventListener('click', function (e) {
  e.preventDefault();
  sqlOffset = questionLimit;
  const formData = new FormData();
  formData.append('search', searchInput.value.trim().toLowerCase());
  formData.append('offset', sqlOffset.toString());
  formData.append('limit', questionLimit.toString());
  ManageQuestionsPage.sendApiRequest(
    '/api/dashboard/questions/load-questions.php',
    formData
  ).then((response) => {
    let questions = response;
    if (questions === undefined || questions.length === 0) {
      questionMore.classList.add('disabled');
      questionMore.disabled = true;
      ManageQuestionsPage.showMessage([
        'error',
        'Daha fazla soru bulunamadı.',
        'none',
      ]);
    } else {
      for (let i = 0; i < questions.length; i++) {
        let question = questions[i];
        currentQuestions.value.push(question);
        questionTable.append(createQuestionTable(question));
        ManageQuestionsPage.showMessage([
          'success',
          `${questionLimit} soru başarıyla yüklendi.`,
          'none',
        ]);
      }
    }
  });
});

export default function InitQuestions() {
  loadFirstQuestions();
  runSearchQuestions(searchInput);
}
