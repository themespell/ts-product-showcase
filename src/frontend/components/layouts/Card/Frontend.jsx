import React from "react";
import TsProductName from "../__common/components/TsProuductName.jsx";
import TsMemberDesignation from "../__common/components/TsMemberDesignation.jsx";
import TsMemberDescription from "../__common/components/TsMemberDescription.jsx";

import './style.css';

const Card = ({
                  settings,
                  id,
                  title,
                  imageUrl,
                  productGallery,
                  categories,
                  price,
                  regularPrice,
                  salePrice,
                  sku,
                  stockStatus,
                  description,
                  cartUrl,
                  details,
                  animationConfig
              }) => {
    // Calculate discount percentage
    const calculateDiscount = () => {
        if (regularPrice && salePrice) {
            const discount = ((regularPrice - salePrice) / regularPrice) * 100;
            return Math.round(discount);
        }
        return 0;
    };

    const discountPercent = calculateDiscount();

    const renderContent = () => (
        <div className="w-full flex flex-col">
            {/* Product Image Container */}
            <div className="product-image-container">
                {/* Sale Badge */}
                {discountPercent > 0 && (
                    <div className="sale-badge">
                        {discountPercent}% Off
                    </div>
                )}

                {/* Product Image */}
                <img
                    id={`${title?.replace(/\s+/g, "-").toLowerCase()}-${id}`}
                    src={imageUrl}
                    alt={title}
                />

                {/* Add to Cart Button */}
                <button className="add-to-cart-btn">
                    Add to Cart
                </button>
            </div>

            {/* Product Info */}
            <div className="pt-4 text-center">
                {title && <TsProductName>{title}</TsProductName>}

                {/* Price Display */}
                <div className="flex items-center justify-center gap-2 mt-1">
                    {salePrice ? (
                        <>
              <span className="text-base font-semibold text-gray-800">
                ${salePrice}
              </span>
                            {regularPrice && (
                                <span className="text-sm text-gray-400 line-through">
                  ${regularPrice}
                </span>
                            )}
                        </>
                    ) : (
                        <span className="text-base font-semibold text-gray-800">
              ${price}
            </span>
                    )}
                </div>
            </div>
        </div>
    );

    // Handle different animation types
    if (!animationConfig) {
        return renderContent();
    }

    if (animationConfig.type === "single") {
        return <div className={animationConfig.class}>{renderContent()}</div>;
    }

    if (animationConfig.type === "wrapper") {
        return (
            <div className={animationConfig.parent}>
                <div className={animationConfig.wrapper}>{renderContent()}</div>
            </div>
        );
    }

    return renderContent();
};

export default Card;