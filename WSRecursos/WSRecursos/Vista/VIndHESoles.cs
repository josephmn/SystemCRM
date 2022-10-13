using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VIndHESoles : BDconexion
    {
        public List<EIndHESoles> Listar_IndHESoles()
        {
            List<EIndHESoles> lCIndHESoles = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CIndHESoles oVIndHESoles = new CIndHESoles();
                    lCIndHESoles = oVIndHESoles.Listar_IndHESoles(con);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCIndHESoles);
        }
    }
}