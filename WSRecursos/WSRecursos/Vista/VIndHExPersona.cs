using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VIndHExPersona : BDconexion
    {
        public List<EIndHExPersona> Listar_IndHExPersona()
        {
            List<EIndHExPersona> lCIndHExPersona = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CIndHExPersona oVIndHExPersona = new CIndHExPersona();
                    lCIndHExPersona = oVIndHExPersona.Listar_IndHExPersona(con);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCIndHExPersona);
        }
    }
}