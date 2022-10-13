using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VIndDotacionCargo : BDconexion
    {
        public List<EIndDotacionCargo> Listar_IndDotacionCargo()
        {
            List<EIndDotacionCargo> lCIndDotacionCargo = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CIndDotacionCargo oVIndDotacionCargo = new CIndDotacionCargo();
                    lCIndDotacionCargo = oVIndDotacionCargo.Listar_IndDotacionCargo(con);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCIndDotacionCargo);
        }
    }
}