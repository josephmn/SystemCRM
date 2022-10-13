using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VLogin : BDconexion
    {
        public List<ELogin> Login(String usuario, String password)
        {
            List<ELogin> lCLogin = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CLogin oVLogin = new CLogin();
                    lCLogin = oVLogin.Listar_Login(con, usuario, password);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCLogin);
        }
    }
}