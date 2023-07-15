import { useState } from "react";
import "./App.css";
import Auth from "./axios/Auth";

function App() {
  let [userName, setUsername] = useState("");
  let [email, setEmail] = useState("");
  let [password, setPassword] = useState("");
  let [result, setResult] = useState([]); // 為了顯示後端得到的資料

  const handleRegister = () => {
    // 將資料發送到 AuthService 的 register
    Auth.signup(email, userName, password).then((result) => {
      console.log(result);
      console.log(result.data);
    });
  };
  const handleGetUserInfo = async () => {
    // 將資料發送到 AuthService 的 register
    Auth.userInfo(email).then((result) => {
      console.log(result);
      setResult(result.data); // 更新result
    });
  };
  return (
    <div className="App">
      <div className="register">
        <h1>註冊帳戶</h1>
        <div>
          username :
          <input
            type="text"
            onChange={(event) => {
              setUsername(event.target.value);
            }}
          />
        </div>
        <div>
          email :
          <input
            type="text"
            onChange={(event) => {
              setEmail(event.target.value);
            }}
          />
        </div>
        <div>
          password :
          <input
            type="text"
            onChange={(event) => {
              setPassword(event.target.value);
            }}
          />
        </div>
        <input type="submit" value={"submit"} onClick={handleRegister} />
      </div>
      <div className="getData">
        <h1>取得資料</h1>
        <div>
          email :
          <input
            type="text"
            onChange={(event) => {
              setEmail(event.target.value);
            }}
          />
        </div>
        <input type="submit" value={"submit"} onClick={handleGetUserInfo} />

        {/* 顯示 result */}
        {result &&
          result.map((item) => (
            <div key={item.email}>
              <div>{item.email}</div>
              <div>{item.userName}</div>
              <div>{item.pwd}</div>
            </div>
          ))}
      </div>
    </div>
  );
}

export default App;
