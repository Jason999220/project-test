import { useState } from "react";
import "./App.css";
import Auth from "./axios/Auth";

function App() {
    const [item, setItem] = useState('cookie')
    const [itemNO, setItemNO] = useState('A01')
    const [des, setDes] = useState('good')
    const [price, setPrice] = useState(300)
    // 將數據給後端
    const handleOrder = () => {
        console.log(price)
        Auth.order(item, itemNO, des, price).then((order) => { console.log(order) })
    }
    return (
        <div className="App">
            <div>
                <h1>商品名稱 : {item}</h1>
                <h1>商品編號 : {itemNO}</h1>
                <h1>描述 : {des}</h1>
                <h1>金額 : ${price}</h1>
                <div >
                    <button onClick={handleOrder}
                        type="submit">
                        Submit Order
                    </button>
                </div>
            </div>
        </div>
    );
}

export default App;
