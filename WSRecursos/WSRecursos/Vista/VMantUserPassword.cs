using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VMantUserPassword : BDconexion
    {
        public List<EMantenimiento> MantUserPassword(String dni, String user)
        {
            List<EMantenimiento> lCEMantenimiento = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CMantUserPassword oVMantUserPassword = new CMantUserPassword();
                    lCEMantenimiento = oVMantUserPassword.MantUserPassword(con, dni, user);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCEMantenimiento);
        }
    }
}