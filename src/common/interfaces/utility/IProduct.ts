export default interface IProduct {
  id: string;
  name: string;
  category: string;
  sub_category: string;
  price: string;
  shipping_cost: string;
  fee_cost: string;
  status: string;
  image1: string;
  image2: string;
  image3: string;
  image4: string;
  image5: string;
  image6: string;
  root_name: string;
  tags: string;
  description: string;
  quality: string;
  shipment: string;
  featured: string;
  [key: string]: string;
}
