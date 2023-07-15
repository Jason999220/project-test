import { useState } from "react";
import "./App.css";
import Auth from "./axios/Auth";

function App() {
  let [userName, setUsername] = useState("");
  let [email, setEmail] = useState("");
  let [password, setPassword] = useState("");
  const handleRegister = () => {
    // 將資料發送到 AuthService 的 register
    Auth.signup(email, userName, password).then((result) => {
      console.log(result);
      console.log(result.data);
    });
  };
  return (
    <div className="App">
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
  );
}

export default App;
