export type PageType = "hash" | "btn";

export default interface IRouter {
  loadType: PageType;
  setPageContent(type: string, page: HTMLElement): void;
  loadPage(type: PageType, target: string): void;
}
