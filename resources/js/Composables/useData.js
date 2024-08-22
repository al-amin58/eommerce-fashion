import {computed, watch, ref} from "vue";

export function useData(){
    const tabs = [
        { name: 'From This Device', value: ['file'] },
        { name: 'From the Web', value: ['url'] },
        { name: 'Both', value: ['file', 'url'] },
    ];

    const markup = `
    <h2>
        <img src="https://js.devexpress.com/Demos/WidgetsGallery/JSDemos/images/widgets/HtmlEditor.svg" alt="HtmlEditor">
        Formatted Text Editor (HTML Editor)
    </h2>
    <br>
    <p>DevExtreme JavaScript HTML Editor is a client-side WYSIWYG text editor that allows its users to format textual and visual content and store it as HTML or Markdown.</p>
    <p>Supported features:</p>
    <ul>
        <li>Inline formats:
            <ul>
                <li><strong>Bold</strong>, <em>italic</em>, <s>strikethrough</s> text formatting</li>
                <li>Font, size, color changes (HTML only)</li>
            </ul>
        </li>
        <li>Block formats:
            <ul>
                <li>Headers</li>
                <li>Text alignment</li>
                <li>Lists (ordered and unordered)</li>
                <li>Code blocks</li>
                <li>Quotes</li>
            </ul>
        </li>
        <li>Custom formats</li>
        <li>HTML and Markdown support</li>
        <li>Mail-merge placeholders (for example, %username%)</li>
        <li>Adaptive toolbar for working images, links, and color formats</li>
        <li>Image upload: drag-and-drop images onto the form, select files from the file system, or specify a URL.</li>
        <li>Copy-paste rich content (unsupported formats are removed)</li>
        <li>Tables support</li>
    </ul>
    <br>
    <p>Supported frameworks and libraries</p>
    <table>
        <tr>
            <td><strong>jQuery</strong></td>
            <td style="text-align: right;">v2.1 - v2.2 and v3.x</td>
        </tr>
        <tr>
            <td><strong>Angular</strong></td>
            <td style="text-align: right;">v7.0.x - v10.0.x</td>
        </tr>
        <tr>
            <td><strong>React</strong></td>
            <td style="text-align: right;">v16.2+</td>
        </tr>
        <tr>
            <td><strong>Vue</strong></td>
            <td style="text-align: right;">v2.6.3+</td>
        </tr>
    </table>
`;


    //discount span color
    const spanIsRed = true;

    // formatted price
    const priceSignature = '৳';
    const showSignBefore = false;
    const priceStructure = (price) => showSignBefore ? `${priceSignature} ${price}` : `${price} ${priceSignature}`

    // discountPrice calculations
    const discountPrice = (product_price, discount_price, discount_type) => {
        if (discount_type === 'flat'){
            return parseInt(product_price) - parseInt(discount_price);
        }else{
            let discount = (parseInt(product_price) * parseInt(discount_price)) / 100;
            return parseInt(product_price) - discount;
        }
    }



    return {markup, tabs, priceSignature, priceStructure, discountPrice, spanIsRed}

}
