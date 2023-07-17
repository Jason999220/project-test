import React from "react";
import ReactDOM from "react-dom/client";
import App from "./App";
import ECPay from "./ECPay";

const root = ReactDOM.createRoot(document.getElementById("root"));
root.render(
  <React.StrictMode>
    {/* axios 測試 */}
    <App />
    {/* 綠界測試 */}
    {/* <ECPay /> */}
  </React.StrictMode>
);
