using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VSemana : BDconexion
    {
        public List<ESemana> Listar_Semana(Int32 post, String user)
        {
            List<ESemana> lCSemana = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CSemana oVSemana = new CSemana();
                    lCSemana = oVSemana.Listar_Semana(con, post, user);
                    //lCSemana = oVSemana.Listar_Semana(con, anhio);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCSemana);
        }
    }
}