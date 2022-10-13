using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VMantJefeAsistente : BDconexion
    {
        public List<EMantenimiento> MantJefeAsistente(Int32 post, String dnijefe, String dniasistente, String user)
        {
            List<EMantenimiento> lCEMantenimiento = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CMantJefeAsistente oVMantJefeAsistente = new CMantJefeAsistente();
                    lCEMantenimiento = oVMantJefeAsistente.MantJefeAsistente(con, post, dnijefe, dniasistente, user);
                }
                catch (SqlException)
                {

                }
            }
            return (lCEMantenimiento);
        }
    }
}