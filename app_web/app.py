from flask import Flask, render_template, request, redirect, url_for, session


app = Flask(__name__)
app.config['MYSQL_HOST'] = 'localhost'
app.config['MYSQL_USER'] = 'root'
app.config['MYSQL_PASSWORD'] = ''
app.config['MYSQL_DB'] = 'danis'
app.config['MYSQL_CURSORCLASS'] = 'DictCursor'


@app.route('/')
def home():
    return render_template("index.html")

@app.route('/logout', methods=["GET", "POST"])
def logout():
    session.clear()
    return render_template("index.html")

@app.route('/login',methods=["GET","POST"])
def login():
    if request.method == 'POST':
        email = request.form['email']
        password = request.form['password']

        cur = mysql.connection.cursor()
        cur.execute("SELECT * FROM users WHERE email=%s",(email,))
        user = cur.fetchone()
        cur.close()

        if len(user) > 0:
            if  password == user["password"]:
                session['name'] = user['name']
                session['email'] = user['email']
                session['tipo'] = user['id_tip_usu']

                if session['tipo'] == 1:
                    return render_template("premium/home.html")

                elif session['tipo'] == 2:
                    return render_template("basic/homeTwo.html")
            else:
                return "Error, correo o contraseña no validas"
        else:
            return "No existe el usuario"
    else:
        return render_template("login.html")

        
@app.route('/register', methods=["GET", "POST"])
def register():
    cur = mysql.connection.cursor()
    cur.execute("SELECT * FROM tip_usu")
    tipo = cur.fetchall()

    cur = mysql.connection.cursor()
    cur.execute("SELECT * FROM sexo_interes")
    interes = cur.fetchall()

    cur.close()

    if request.method == 'GET':
        return render_template("register.html", tipo=tipo, interes=interes)
        
    else:
        name = request.form['name']
        email = request.form['email']
        password = request.form['password']
        tip = request.form['tipo']
        interes = request.form['interes']
        
        cur = mysql.connection.cursor()
        cur.execute("INSERT INTO users (name, email, password, id_tip_usu, interes) VALUES (%s,%s,%s,%s,%s)",(name,email,password,tip,interes, ))
        mysql.connection.commit()
        return redirect(url_for('login'))
""" 

        cur = mysql.connection.cursor()
        cur.execute("SELECT * FROM users WHERE name = name OR email = email" )
        dato = cur.fetchall()
        cur.close()

        if dato: """
            

if __name__ == '__main__':
    app.secret_key = "^A%DJAJU^JJ123"
    app.run(debug=True)