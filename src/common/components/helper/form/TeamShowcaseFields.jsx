import { useState, useEffect } from 'react';
import { Form, Input } from 'antd';
import { fetchData } from '../../../services/fetchData';
import { TsInput, TsAdvanceSelect } from '../../controls/tsControls';
import {getTranslations} from "../../../utils/translations.js";

function TeamShowcaseFields({ form, post_id }) {
  const translations = getTranslations();
  const [products, setProducts] = useState([]);

  // Fetch team members for select options
  useEffect(() => {
    fetchData('tsproduct/products/fetch', (response) => {
      if (response.success && response.data) {
        console.log(response.data);
        const options = response.data.map((product) => ({
          label: product.name,
          value: product.post_id,
          image: product.image || product.featured_image || product.thumbnail,
          price: product.price || product.regular_price,
          sku: product.sku || product.product_sku
        }));
        setProducts(options);
      } else {
        console.error('Failed to fetch Products.');
      }
    });
  }, []);

  // Fetch showcase data if `id` is provided and set form values
  useEffect(() => {
    if (post_id) {
      fetchData(`tsproduct/product_showcase/fetch/single`, (response) => {
        if (response.success && response.data) {
          form.setFieldsValue({
            title: response.data.title,
            products: response.data.meta_data.products.map((product) => ({
              label: product.name,
              value: product.post_id,
              image: product.image || product.featured_image || product.thumbnail,
              price: product.price || product.regular_price,
              sku: product.sku || product.product_sku
            }))
          });
        } else {
          console.error('Failed to fetch showcase data.');
        }
      }, { post_id: post_id });
    }
  }, [post_id, form]);

  return (
      <div className="p-6">
        <TsInput
            label={translations.showcaseName}
            name="title"
            required={true}
        />

        <Form.Item
            name="products"
            rules={[{ required: true, message: 'Please select products'}]}
        >
          <TsAdvanceSelect
              label={translations.teamMember}
              defaultValue={form.getFieldValue('products')}
              options={products}
              mode="multiple"
              showImage={true}
              showPrice={true}
              showSku={true}
              pricePrefix="$"
              skuPrefix="SKU: "
              imageSize={50}
          />
        </Form.Item>
      </div>
  );
}

export default TeamShowcaseFields;