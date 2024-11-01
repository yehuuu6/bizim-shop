import PanelClass from '@/classes/PanelController';

/**
 * Directly gets response and displays the message. Use this if you don't need to do stuff with response.
 * @param panelObject The panel object
 * @param url The url to send the request
 * @param formData The form data to send
 * @returns void
 */
export function getApiResponse(
  panelObject: PanelClass,
  url: string,
  formData: FormData
) {
  panelObject.sendApiRequest(url, formData).then((data) => {
    const response = data[0];
    panelObject.showMessage(data);
  });
}

// 0 = Beklemede, 1 = Hazırlanıyor, 2 = Kargoya Verildi, 3 = Teslim Edildi, 4 = İptal Edildi, 5 = İade Edildi, 6 = Tamamlandı, 7 = Tamamlanmadı
export function setOrderStatus(status: string) {
  let statusText: string | undefined = 'Hata';

  switch (status) {
    case '0':
      statusText = 'Beklemede';
      break;
    case '1':
      statusText = 'Hazırlanıyor';
      break;
    case '2':
      statusText = 'Kargoya Verildi';
      break;
    case '3':
      statusText = 'Dağıtımda';
      break;
    case '4':
      statusText = 'Teslim Edildi';
      break;
    case '5':
      statusText = 'İptal Edildi';
      break;
    case '6':
      statusText = 'İade Edildi';
      break;
    default:
      statusText = 'Bilinmeyen Durum';
      break;
  }
  return statusText;
}

export function debounce(callback: any, delay: number) {
  let timer: any;
  return function () {
    clearTimeout(timer);
    timer = setTimeout(callback, delay);
  };
}

export function clearAvatarInput() {
  const avatarInput: HTMLInputElement =
    document.querySelector('#avatar-input')!;
  avatarInput.value = '';
  const avatarInputDisplayer: HTMLParagraphElement = document.querySelector(
    '#avatar-input-displayer'
  )!;
  avatarInputDisplayer.innerText = 'Dosya seçilmedi.';
}

export function trimSentence(sentence: string, maxLength: number) {
  if (sentence.length > maxLength) {
    sentence = sentence.substring(0, maxLength - 3) + '...';
  }
  return sentence;
}

export function getDate(raw: string) {
  const [year, month_t, day] = raw.split('-');
  const month_names = [
    'Jan',
    'Feb',
    'March',
    'April',
    'May',
    'June',
    'July',
    'Aug',
    'Sep',
    'Oct',
    'Nov',
    'Dec',
  ];
  const month = month_names[Number(month_t) - 1];
  const day_trimmed = Number(day).toString();
  return `${month} ${day_trimmed}, ${year}`;
}
