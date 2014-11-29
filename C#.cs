//1. Declare variables
        decimal firstNumber;
        decimal secondNumber;
        decimal result;
        //2. get values for the variables
        firstNumber = Convert.ToDecimal(txtFirstNumber.Text);
        Trace.Warn("firstNumber = " + firstNumber);

        secondNumber = Convert.ToDecimal(txtSecondNumber.Text);
        Trace.Warn("secondNumber = " + secondNumber);
        //3. calculate
        result = firstNumber + secondNumber;
        //4. display
        <div id="divBasePay"></div>
      //  document.getElementById("divBasePay").innerHTML = "$" + basePayAmount.toFixed(2);
       <div id="divBasePay"></div> = "<b>" + "Result:" + "" + "" + result.ToString() + "</b>";
      // lblDisplayCalculation.Text = "<b>" + "Result:" + "" + "" + result.ToString() + "</b>";
        Trace.Warn("result = " + result);
