using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VIndAusentismoxCargo : BDconexion
    {
        public List<EIndAusentismoxCargo> Listar_IndAusentismoxCargo()
        {
            List<EIndAusentismoxCargo> lCIndAusentismoxCargo = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CIndAusentismoxCargo oVIndAusentismoxCargo = new CIndAusentismoxCargo();
                    lCIndAusentismoxCargo = oVIndAusentismoxCargo.Listar_IndAusentismoxCargo(con);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCIndAusentismoxCargo);
        }
    }
}