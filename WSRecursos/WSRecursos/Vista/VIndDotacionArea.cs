using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VIndDotacionArea : BDconexion
    {
        public List<EIndDotacionArea> Listar_IndDotacionArea()
        {
            List<EIndDotacionArea> lCIndDotacionArea = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CIndDotacionArea oVIndDotacionArea = new CIndDotacionArea();
                    lCIndDotacionArea = oVIndDotacionArea.Listar_IndDotacionArea(con);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCIndDotacionArea);
        }
    }
}