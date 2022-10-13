using System;
using System.Collections.Generic;
using System.Collections.ObjectModel;
using System.Collections.Specialized;
using System.Linq;
using System.Web;
using System.Data;
using System.Data.SqlClient;
using WSRecursos.Entity;

namespace WSRecursos.Controller
{
    public class CIndHExPersona
    {
        public List<EIndHExPersona> Listar_IndHExPersona(SqlConnection con)
        {
            List<EIndHExPersona> lEIndHExPersona = null;
            SqlCommand cmd = new SqlCommand("ASP_INDHEXPERSONA", con);
            cmd.CommandType = CommandType.StoredProcedure;
            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEIndHExPersona = new List<EIndHExPersona>();

                EIndHExPersona obEIndHExPersona = null;
                while (drd.Read())
                {
                    obEIndHExPersona = new EIndHExPersona();
                    obEIndHExPersona.v_cargo = drd["v_cargo"].ToString();
                    obEIndHExPersona.i_dotacion = drd["i_dotacion"].ToString();
                    obEIndHExPersona.i_he25 = drd["i_he25"].ToString();
                    obEIndHExPersona.i_he35 = drd["i_he35"].ToString();
                    obEIndHExPersona.i_he100 = drd["i_he100"].ToString();
                    obEIndHExPersona.i_heesp = drd["i_heesp"].ToString();
                    obEIndHExPersona.i_por25 = drd["i_por25"].ToString();
                    obEIndHExPersona.i_por35 = drd["i_por35"].ToString();
                    obEIndHExPersona.i_por100 = drd["i_por100"].ToString();
                    obEIndHExPersona.i_poresp = drd["i_poresp"].ToString();
                    lEIndHExPersona.Add(obEIndHExPersona);
                }
                drd.Close();
            }

            return (lEIndHExPersona);
        }
    }
}