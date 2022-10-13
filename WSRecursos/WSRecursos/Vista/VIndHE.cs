using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VIndHE : BDconexion
    {
        public List<EIndHE> Listar_IndHE()
        {
            List<EIndHE> lCIndHE = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CIndHE oVIndHE = new CIndHE();
                    lCIndHE = oVIndHE.Listar_IndHE(con);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCIndHE);
        }
    }
}