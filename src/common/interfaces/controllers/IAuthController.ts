export default interface IAuthController {
  form: HTMLFormElement;
  logger: HTMLParagraphElement;
  loader: HTMLDivElement;
  url: string;
  returnUrl: string;
  goBackTime: number;
  timer: any;
  timer2: any;
}
